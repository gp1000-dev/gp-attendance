<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Http\Requests\UpdateProfile;
use App\Http\Requests\UpdatePassword;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the User page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('user/index');
    }

    /**
     * Change userpassword page
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function password()
    {
        return view('user/password');
    }

    /**
     * Update profile page
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit()
    {
        $user = Auth::user();

        return view('user/update', compact('user'));
    }

    /**
     * User profile update process
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function update(UpdateProfile $request)
    {
        $user_id = Auth::user()->id;
        $user = User::find($user_id);

        $user->last_name = $request->last_name;
        $user->first_name = $request->first_name;

        $user->last_kana_name = $request->last_kana_name;
        $user->first_kana_name = $request->first_kana_name;

        $user->gender = $request->gender;

        $user->birthdate = Carbon::createFromDate(
            $request->birthdate_year,
            $request->birthdate_month,
            $request->birthdate_day
        );

        $user->save();

        return redirect()->route('user.index')->with('flash_message', 'ユーザー情報を更新しました。');
    }

    /**
     * User password update process
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function updatePassword(UpdatePassword $request)
    {
        // IDのチェック
        if ($request->id != Auth::user()->id) {
            return redirect()->route('password.change')->with('warning', '致命的なエラーです。');
        }

        // ユーザー情報の取得
        $user_id = Auth::user()->id;
        $user = User::find($user_id);

        // 現在のパスワードをチェック
        if (!password_verify($request->password, $user->password)) {
            return redirect()->route('password.change')->with('warning', 'パスワードが違います。');
        }

        // パスワードを保存
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('user.index')->with('flash_message', 'パスワードを変更しました。');
    }
}
