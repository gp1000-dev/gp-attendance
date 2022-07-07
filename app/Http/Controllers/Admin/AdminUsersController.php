<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

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
}
