<?php

namespace App\Http\Controllers;

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

        return view('attendances/index')->with('dt', $dt);
    }

    /**
     * show attendance create page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create(Request $request)
    {
        $query = null; /* クエリがなければヌルになる */
        $query = $request->date; /* ?date=のみ受け付ける */

        /* 正規表現で年月日の形式か判定する */
        if (preg_match('/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/', $query)) {
            /* 日付型に変換する */
            $date = explode("-", $query);
            $dt = Carbon::create($date[0], $date[1], $date[2], 0, 0, 0);
            /* 今日の日付だった場合のみビューに渡す */
            if ($dt->eq(Carbon::today())) {
                return view('attendances/create');
            } else {
            /* 勤怠表示画面に戻す */
                return redirect()->route('attendances.index');
            }
        } else {
            return redirect()->route('attendances.index');
        }
    }
}
