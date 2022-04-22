<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

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
     * @return
     */
    public function update(Request $request)
    {
        $user_id = Auth::user()->id;
        $user = User::find($user_id);

        $user->last_name = $request->last_name;
        $user->first_name = $request->first_name;
        $user->gender = $request->gender;

        $year = $request->birthdate_year;
        $month = $request->birthdate_month;
        $day = $request->birthdate_day;

        $year = (string)$year;

        if ($month < 10) {
            $month = '0' . $month;
        } else {
            $month = (string)$month;
        }

        if ($day < 10) {
            $day = '0' . $day;
        } else {
            $day = (string)$day;
        }

        $birthdate = $year . '-' . $month . '-' . $day;

        $birthdate = strtotime($birthdate);

        $user->birthdate = $birthdate;

        $user->save();


        return redirect()->route('user.index');
    }
}
