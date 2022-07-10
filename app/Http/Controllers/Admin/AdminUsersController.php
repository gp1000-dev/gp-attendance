<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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

    public function add()
    {
        return view('admin.users.add');
    }

    public function store(UserRequest $request)
    {
        $user = User::create([
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'last_kana_name' => $request->last_kana_name,
            'first_kana_name' => $request->first_kana_name,
            'gender' => $request->gender,
            'birthdate' => Carbon::createFromDate(
                $request->birthdate_year,
                $request->birthdate_month,
                $request->birthdate_day,
            ),
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return redirect()->route('admin.users.show', ['id' => $user->id])->with('flash_message', 'ユーザー情報を登録しました。');
    }
}
