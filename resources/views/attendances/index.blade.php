@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
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
                                $period = \Carbon\CarbonPeriod::create(
                                    $dt->copy()->startOfMonth(),
                                    $dt->copy()->endOfMonth()
                                );
                            @endphp
                            @foreach ($period as $date)
                                <tr class="{{ $date->dayOfWeek === 0 || $date->dayOfWeek === 6 ? 'table-secondary' : '' }}">
                                    <td>{{ $date->isoFormat('D(ddd)') }}</td>
                                    <td>{{ $date->dayOfWeek !== 0 && $date->dayOfWeek !== 6 ? '出' : '' }}</td>
                                    <td>{{ $date->dayOfWeek !== 0 && $date->dayOfWeek !== 6 ? '13:00' : '' }}</td>
                                    <td>{{ $date->dayOfWeek !== 0 && $date->dayOfWeek !== 6 ? '18:00' : '' }}</td>
                                    <td>{{ $date->dayOfWeek !== 0 && $date->dayOfWeek !== 6 ? '05:00' : '' }}</td>
                                    <td>{{ $date->dayOfWeek !== 0 && $date->dayOfWeek !== 6 ? '体調不良' : '' }}</td>
                                    <td>
                                        @if ($date->dayOfWeek === 0 || $date->dayOfWeek === 6)

                                        @elseif ($date->eq(\Carbon\Carbon::today()))
                                            <button class="btn btn-primary btn-sm">登録</button>
                                        @elseif ($date->lt(\Carbon\Carbon::today()))
                                            <button class="btn btn-primary btn-sm">変更</button>
                                        @else

                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td>当月計</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{ '110:00' }}</td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <div>
                        <a href="{{ Route('attendances.index') }}"><< 前月</a>
                        &ensp;
                        @if ($dt->copy()->endOfMonth()->lt(\Carbon\Carbon::today()))
                            <a href="{{ Route('attendances.index') }}">>> 次月</a>
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
