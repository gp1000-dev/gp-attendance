<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        /* リクエストパラメータによる日付の指定処理 */
        $query = null; /* 指定がなければヌルになる */
        $query = $request->month; /* ?month=の場合受け付ける */
        /* 正規表現で受け付ける表現を限る */
        if (preg_match('/^[0-9]{4}\-[0-9]{2}$/', $query)){
            /* 年と月に分割する */
            $date = explode("-", $query);
            /* 1年以降の1月から12月までを受け付ける */
            if ($date[0] >= 1 && $date[1] >= 1 && $date[1] <= 12) {
                $dt = Carbon::createFromDate($date[0], $date[1], 01);
            } else {
                $dt = Carbon::today();
            }
        /* 正規表現で弾かれたら今日を指定したことにする */
        } else {
            $dt = Carbon::today();
        }

        /* 1ヶ月分のデータを取得する */
        $attendances = Attendance::where('user_id', Auth::user()->id)
            ->where('date', '>=', $dt->copy()->startOfMonth())
            ->where('date', '<=', $dt->copy()->endOfMonth())
            ->get();

        return view('attendances/index', compact('dt', 'attendances'));
    }

    /**
     * show attendance create page.
     *
     * @return Illuminate\Http\RedirectResponse
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

    /**
     * Store attendance data.
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        return redirect()->route('attendances.index');
    }
}
