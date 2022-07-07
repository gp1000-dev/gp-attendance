<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Models\User;

use App\Http\Requests\UserRequest;


class AdminUsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show users page
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', ['users' => $users]);
    }
    public function show($id)
    {
        $user = User::find($id);
        if (is_null($user)) {
            abort(403);
        }
        return view('admin.users.show', ['user' => $user]);
    }
    public function edit($id)
    {
        $user = User::find($id);
        if (is_null($user)) {
            abort(403);
        }
        return view('admin.users.edit', ['user' => $user]);
    }
    public function update(UserRequest $request, $id)
    {
        // IDチェック
        // if ($request->id != Auth::user()->id) {
        //     return redirect()->route('user.edit')->with('warning', '致命的なエラーです。');
        // }

        // ユーザー情報の取得
        $user_id = $id;
        $user = User::find($user_id);
        if (is_null($user)) {
            abort(403);
        }

        // 入力情報のDBへの書き込み準備
        // 姓と名前
        $user->last_name = $request->last_name;
        $user->first_name = $request->first_name;
        // 姓カナと名前カナ
        $user->last_kana_name = $request->last_kana_name;
        $user->first_kana_name = $request->first_kana_name;
        // 性別
        $user->gender = $request->gender;
        // 誕生日
        $user->birthdate = Carbon::createFromDate(
            $request->birthdate_year,
            $request->birthdate_month,
            $request->birthdate_day
        );
        $user->email = $request->email;
        // DBへの保存
        $user->save();

        // ユーザーページへリダイレクト
        return redirect()->route('admin.users.show', ['id' => $user->id])->with('flash_message', 'ユーザー情報を更新しました。');
    }
}
