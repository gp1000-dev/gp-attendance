@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ $dt->year }}年{{ $dt->month }}月 の勤怠</div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>日付</td>
                                <td>出所</td>
                                <td>開始時刻</td>
                                <td>終了時刻</td>
                                <td>通所時間</td>
                                <td>備考</td>
                                <td></td>
                            </tr>
                            @php
                                /* 月初から月末までの日付を作る */
                                $period = \Carbon\CarbonPeriod::create(
                                    /* オブジェクトインスタンスなので値を保持するためコピーする必要がある */
                                    $dt->copy()->startOfMonth(),
                                    $dt->copy()->endOfMonth()
                                );
                                $totalWorkMinutes = 0;
                            @endphp
                            {{-- 1日づつ処理する --}}
                            @foreach ($period as $date)
                                {{-- @php
                                    $attendance = $attendances
                                        ->first(function ($a) use($date) {
                                            return $a->date->eq($date);
                                        });
                                @endphp --}}
                                @php
                                    /* DBにデータがある日だけデータを入れる */
                                    $attendance = null; /* データがない日はヌルが入る */
                                    /* DBから取得したレコードを1件づつ確認する */
                                    foreach ($attendances as $attendance_) {
                                        /* レコードの中に一致する日付がある場合は */
                                        if ($attendance_->date->eq($date)) {
                                            /* そのデータをその日のデータとする */
                                            $attendance = $attendance_;
                                            break; /* 最初の1件目だけを取り上げる */
                                        }
                                    }
                                @endphp
                                {{-- 日曜日と土曜日は背景が灰色になる --}}
                                <tr class="{{ $date->dayOfWeek === 0 || $date->dayOfWeek === 6 ? 'table-secondary' : '' }}">
                                    {{-- 日本語で日付と曜日を表示する --}}
                                    <td>{{ $date->isoFormat('D(ddd)') }}</td>
                                    {{-- その日のデータがある場合だけ表示する --}}
                                    <td>
                                        {{-- 出席した場合出力する --}}
                                        {{ $attendance ? ($attendance->attended ? '出' : '欠') : '' }}
                                    </td>
                                    <td>
                                        {{-- 出席時間 --}}
                                        {{ $attendance ? ($attendance->start_time ? $attendance->start_time->format('H:i') : '') : '' }}
                                    </td>
                                    <td>
                                        {{-- 退出時間 --}}
                                        {{ $attendance ? ($attendance->end_time ? $attendance->end_time->format('H:i') : '') : '' }}
                                    </td>
                                    <td>
                                        {{-- 出席の場合は勤務時間をメソッドで求める --}}
                                        {{ $attendance ? ($attendance->attended ? $attendance->workTime()->format('H:i') : '') : '' }}
                                    </td>
                                    <td>
                                        {{-- コメント(備考) --}}
                                        {{ $attendance ? $attendance->comment : '' }}
                                    </td>
                                    <td>
                                        {{-- ボタンの表示 --}}
                                        {{-- 過去か今日の場合はボタンを表示する --}}
                                        @if ($date->lte(\Carbon\Carbon::today()))
                                            {{-- 登録が無ければ"登録"ボタン --}}
                                            @if (is_null($attendance))
                                                <a href="{{ route('attendances.create', ['date' => $date->format('Y-m-d')]) }}" class="btn btn-primary btn-sm">登録</a>
                                            {{-- 登録があれば"変更"ボタン --}}
                                            @else
                                                <a href="{{ route('attendances.edit', ['date' => $date->format('Y-m-d')]) }}" class="btn btn-secondary btn-sm">変更</a>
                                            @endif
                                        {{-- 未来の場合はボタンの表示しない --}}
                                        @else

                                        @endif
                                    </td>
                                </tr>
                                @php
                                    if (!is_null($attendance) && $attendance->attended) {
                                        $totalWorkMinutes += ($attendance->workTime()->hour * 60 + $attendance->workTime()->minute);
                                    }
                                @endphp
                            @endforeach
                            <tr>
                                <td>当月計</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{floor($totalWorkMinutes / 60)}}:{{sprintf('%02d', $totalWorkMinutes % 60)}}</td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <div>
                        {{-- 前月へのリンク --}}
                        @php
                            $beforeMonth = $dt->copy()->addMonths(-1)->format('Y-m');
                        @endphp
                        <a href="{{ Route('attendances.index', ['month' => $beforeMonth]) }}"><< 前月</a>
                        &ensp;
                        {{-- 表示している月の末日が今日よりも前ならば過去なのでリンクを付ける --}}
                        @if ($dt->copy()->endOfMonth()->lt(\Carbon\Carbon::today()))
                            {{-- 次月へのリンク --}}
                            @php
                                $nextMonth = $dt->copy()->addMonths(1)->format('Y-m');
                            @endphp
                            <a href="{{ Route('attendances.index', ['month' => $nextMonth]) }}">>> 次月</a>
                        {{-- 今月ならばリンクを付けない --}}
                        @else
                            <span>>> 次月</span>
                        @endif
                    </div>
                    <div>
                        <a href="">本日分登録</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
