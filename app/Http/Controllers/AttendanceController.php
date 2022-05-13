<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use \Carbon\Carbon;

class AttendanceController extends Controller
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
     * Show attendance view page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $month = $request->month;
        $dt = new Carbon('2022-05-10');

        /* 1月分のデータを取得する */
        $attendances = Attendance::where('user_id', 1)
            ->where('date', '>=', $dt->copy()->startOfMonth())
            ->where('date', '<=', $dt->copy()->endOfMonth())
            ->get();

        return view('attendances/index', compact('dt', 'attendances'));
    }
}
