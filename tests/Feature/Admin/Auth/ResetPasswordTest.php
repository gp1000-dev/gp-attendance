<?php

namespace Tests\Feature\Admin\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AdminResetPasswordNotification;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->admin = Admin::factory()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make('P@ssw0rd'),
        ]);
        Notification::fake();
    }

    /**
     * パスワードリセット
     *
     * @return void
     */
    public function test_resetPassword_正常()
    {
        // パスワードリセット画面
        $response = $this->get('/admin/password/reset');
        $response->assertStatus(200);

        // パスワードリセットメール送信
        $response = $this->post('/admin/password/email', [
            'email' => $this->admin->email,
        ]);
        $response->assertStatus(302)->assertRedirect('/admin/password/reset')
            ->assertSessionHasNoErrors()
            ->assertSessionHas('status', 'パスワードリセットメールを送信しました。');

        // メール送信確認
        $token = '';
        Notification::assertSentTo(
            $this->admin,
            AdminResetPasswordNotification::class,
            function ($notification, $channels) use (&$token) {
                $token = $notification->token;
                return true;
            }
        );

        // パスワード再登録画面
        $response = $this->get('/admin/password/reset/'.$token);
        $response->assertStatus(200);

        // パスワード再登録
        $newPassword = 'P@ssw0rd2';
        $response = $this->post('/admin/password/reset', [
            'email' => $this->admin->email,
            'token' => $token,
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/admin');
        $response->assertSessionHas('status', 'パスワードをリセットしました。');

        // 認証確認
        $this->assertAuthenticatedAs($this->admin, $guard='admin');

        // パスワード変更確認
        $this->assertTrue(Hash::check($newPassword, $this->admin->fresh()->password));
    }

    /**
     * パスワードリセット：メールアドレス未入力
     *
     * @return void
     */
    public function test_resetPassword_メールアドレス未入力()
    {
        $response = $this->from('/admin/password/reset')
            ->post('/admin/password/email', [
            ]);

        $response->assertStatus(302)->assertRedirect('/admin/password/reset')
            ->assertSessionHasErrors(['email' => 'メールアドレスは必ず指定してください。']);
        Notification::assertNothingSent();
    }

    /**
     * パスワードリセット：メールアドレス非存在
     *
     * @return void
     */
    public function test_resetPassword_メールアドレス非存在()
    {
        $response = $this->from('/admin/password/reset')
            ->post('/admin/password/email', [
                'email' => 'admin2@example.com',
            ]);

        $response->assertStatus(302)->assertRedirect('/admin/password/reset')
            ->assertSessionHasErrors(['email' => 'メールアドレスに一致するユーザーは存在していません。']);
        Notification::assertNothingSent();
    }

    public function valid_user_can_reset_password()
    {
        Notification::fake();

        // ユーザーを1つ作成
        $user = factory(User::class)->create();

        // パスワードリセットをリクエスト
        $response = $this->post('password/email', [
            'email' => $user->email
        ]);

        // トークンを取得

        $token = '';
        Notification::assertSentTo(
            $user,
            ResetPassword::class,
            function ($notification, $channels) use ($user, &$token) {
                $token = $notification->token;
                return true;
            }
        );

        // パスワードリセットの画面へ
        $response = $this->get('password/reset/'.$token);

        $response->assertStatus(200);

        // パスワードをリセット

        $new = 'reset1111';

        $response = $this->post('password/reset', [
            'email'                 => $user->email,
            'token'                 => $token,
            'password'              => $new,
            'password_confirmation' => $new
        ]);

        // ホームへ遷移
        $response->assertStatus(302);
        $response->assertRedirect('/home');
        // リセット成功のメッセージ
        $response->assertSessionHas('status', 'パスワードはリセットされました!');

        // 認証されていることを確認
        $this->assertTrue(Auth::check());

        // 変更されたパスワードが保存されていることを確認
        $this->assertTrue(Hash::check($new, $user->fresh()->password));
    }
}
