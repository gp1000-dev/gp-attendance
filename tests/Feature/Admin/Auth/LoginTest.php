<?php

namespace Tests\Feature\Admin\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->admin = Admin::factory()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make('P@ssw0rd'),
        ]);
    }

    /**
     * 正常ログイン
     *
     * @return void
     */
    public function test_login_正常()
    {
        $response = $this->get('/admin/login');
        $response->assertStatus(200);

        $response = $this->post('/admin/login', [
            'email' => 'admin@example.com',
            'password' => 'P@ssw0rd',
        ]);
        $response->assertStatus(302)->assertRedirect('/admin');
        $this->assertAuthenticatedAs($this->admin, $guard='admin');
    }

    /**
     * メールアドレス不正
     *
     * @return void
     */
    public function test_login_メールアドレス不正()
    {
        $response = $this->get('/admin/login');
        $response->assertStatus(200);

        $response = $this->post('/admin/login', [
            'email' => 'admin1@example.com',
            'password' => 'P@ssw0rd',
        ]);
        $response->assertStatus(302)->assertRedirect('/admin/login')
            ->assertSessionHasErrors(['email' => 'ログイン情報が登録されていません。']);
        $this->assertGuest();
    }

    /**
     * パスワード不正
     *
     * @return void
     */
    public function test_login_パスワード不正()
    {
        $response = $this->get('/admin/login');
        $response->assertStatus(200);

        $response = $this->post('/admin/login', [
            'email' => 'admin@example.com',
            'password' => 'P@ssw0rd1',
        ]);
        $response->assertStatus(302)->assertRedirect('/admin/login')
            ->assertSessionHasErrors(['email' => 'ログイン情報が登録されていません。']);
        $this->assertGuest();
    }

    /**
     * ログアウト
     *
     * @return void
     */
    public function test_logout()
    {
       $response = $this->actingAs($this->admin, $guard='admin');
       $response = $this->get('/admin');
       $response->assertStatus(200);

       $this->post('/admin/logout');
       $response->assertStatus(200);
       $this->assertGuest();
    }
}
