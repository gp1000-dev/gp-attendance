<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Carbon\Carbon;

use App\Http\Requests\AttendanceRequest;

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
        if (preg_match('/^[0-9]{4}\-[0-9]{2}$/', $query)) {
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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create(Request $request)
    {
        $query = null; /* クエリがなければヌルになる */
        $query = $request->date; /* ?date=のみ受け付ける */
        /* 正規表現で年月日の形式か判定する */
        if (!preg_match('/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/', $query)) {
            abort(403);
        }

        /* 日付型に変換する */
        $dt = Carbon::parse($query);
        /* 未来だったら弾く */
        if ($dt->gt(Carbon::today())) {
            abort(403);
        }

        /* DBにレコードが存在する日付は弾く */
        if (Attendance::where('user_id', Auth::user()->id)
            ->where('date', $dt)->exists()
        ) {
            abort(403);
        }

        /* 登録画面に遷移する */
        return view('attendances/create', compact('dt'));
    }

    /**
     * Store attendance data.
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function store(AttendanceRequest $request)
    {
        /* 未来だったら弾く */
        $date = Carbon::parse($request->date);
        if ($date->gt(Carbon::today())) {
            abort(403);
        }

        /* DBに勤務登録があった場合は弾く */
        if (Attendance::where('user_id', Auth::user()->id)
            ->where('date', $request->date)->exists()
        ) {
            abort(403);
        }

        /* 勤怠登録 */
        $attendance = new Attendance();
        /* ユーザーID */
        $attendance->user_id = Auth::user()->id;
        /* 日付 */
        $attendance->date = $request->date;
        if ($request->status === 'off') {
            /* 欠勤の場合 */
            /* 出勤はfalse */
            $attendance->status = $request->status;
            /* 開始時刻はnull */
            $attendance->start_time = null;
            /* 終了時刻はnull */
            $attendance->end_time = null;
        } else {
            /* 出勤の場合 */
            /* 出勤はtrue */
            $attendance->status = $request->status;
            /* 開始時刻 */
            $attendance->start_time = $request->start_time;
            /* 終了時刻 */
            $attendance->end_time = $request->end_time;
        }
        /* コメント */
        $attendance->comment = $request->comment;

        /* DBに登録する */
        $attendance->save();
        /* 何月かを取得 */
        $carbon =  new Carbon($attendance->date);
        $month = $carbon->format('Y-m');

        /* 勤怠表示画面に戻す */
        return redirect()->route('attendances.index',['month' => $month])->with('message', '登録しました。');
    }

    /**
     * Show attendance edit page
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(Request $request)
    {
        $query = null; /* クエリがなければヌルになる */
        $query = $request->date; /* ?date=のみ受け付ける */
        /* 正規表現で年月日の形式か判定する */
        if (!preg_match('/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/', $query)) {
            abort(403);
        }

        /* 日付型に変換する */
        $dt = Carbon::parse($query);
        /* 未来だったら不正 */
        if ($dt->gt(Carbon::today())) {
            abort(403);
        }

        /* 1日分のデータを取得する */
        $attendance = Attendance::where('user_id', Auth::user()->id)
            ->where('date', $dt)
            ->first();

        /* DBにレコードが存在しない日付は不正 */
        if (is_null($attendance)) {
            abort(403);
        }

        /* 編集画面に遷移する */
        return view('attendances/edit', compact('dt', 'attendance'));
    }

    /**
     * Update attendance data.
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function update(AttendanceRequest $request)
    {
        /* 未来だったら不正 */
        $date = Carbon::parse($request->date);
        if ($date->gt(Carbon::today())) {
            abort(403);
        }

        /* 1日分のデータを取得する */
        $attendance = Attendance::where('user_id', Auth::user()->id)
            ->where('date', $request->date)
            ->first();
        /* 何月かを取得 */
        $carbon =  new Carbon($attendance->date);
        $month = $carbon->format('Y-m');
        /* DBにレコードが存在しない日付は不正 */
        if (is_null($attendance)) {
            abort(403);
        }

        /* 出欠の分岐 */
        if ($request->status === 'off') {
            /* 欠勤の場合 */
            /* 開始時刻はnull */
            $attendance->start_time = null;
            /* 終了時刻はnull */
            $attendance->end_time = null;
        } else {
            /* 出勤の場合 */
            /* 開始時刻 */
            $attendance->start_time = $request->start_time;
            /* 終了時刻 */
            $attendance->end_time = $request->end_time;
        }
        /* 出退勤状況 */
        $attendance->status = $request->status;
        /* コメント */
        $attendance->comment = $request->comment;

        /* DBに登録する */
        $attendance->save();

        /* 勤怠表示画面に戻す */
        return redirect()->route('attendances.index',['month' => $month])->with('message', '変更しました。');
    }

    /**
     * Delete attendance data.
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        /* 未来だったら不正 */
        $date = Carbon::parse($request->date);
        if ($date->gt(Carbon::today())) {
            abort(403);
        }

        /* 1日分のデータを取得する */
        $attendance = Attendance::where('user_id', Auth::user()->id)
            ->where('date', $request->date)
            ->first();
        /* 何月かを取得 */
        $carbon =  new Carbon($attendance->date);
        $month = $carbon->format('Y-m');
        /* DBにレコードが存在しない日付は不正 */
        if (is_null($attendance)) {
            abort(403);
        }

        /* レコードを削除する */
        $attendance->delete();

        /* 勤怠表示画面に戻す */
        return redirect()->route('attendances.index',['month' => $month])->with('message', '取消しました。');
    }
}
