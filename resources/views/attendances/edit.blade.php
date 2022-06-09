@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $message)
                    <ul>
                        <li>{{ $message }}</li>
                    </ul>
                @endforeach
            </div>
        @endif
        <div class="col-md-8">
            <div class="card">
                <form method="POST" action="">
                    @csrf

                    <div class="card-header">勤怠編集</div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tbody>
                                @php
                                    $default_start_time = config('app.attendance.default_start_time');
                                    $default_end_time = config('app.attendance.default_end_time');
                                    $min_start_time = config('app.attendance.min_start_time');
                                    $max_end_time = config('app.attendance.max_end_time');
                                    $time_duration = \Carbon\Carbon::create(config('app.attendance.time_duration'));
                                    $time_duration_minutes = $time_duration->hour * 60 + $time_duration->minute;

                                    $period = \Carbon\CarbonPeriod::create($min_start_time, $max_end_time)->minutes($time_duration_minutes)->toArray();
                                    $start_time = is_null($attendance->start_time) ? \Carbon\Carbon::create($default_start_time) : $attendance->start_time;
                                    $end_time = is_null($attendance->end_time) ? \Carbon\Carbon::create($default_end_time) : $attendance->end_time;
                                @endphp
                                <tr>
                                    <th class="text-start">日付</th>
                                    <td>
                                        {{ $dt->copy()->isoFormat('Y年M月D日（ddd）') }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-start">開始時刻</th>
                                    <td>
                                        <select id="start_time" name="start_time">
                                            @foreach ($period as $time)
                                                <option value="{{ $time->format('H:i') }}" {{ $time->eq($start_time) ? 'selected' : '' }}>{{ $time->format('H:i') }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-start">終了時刻</th>
                                    <td>
                                        <select id="end_time" name="end_time">
                                            @foreach ($period as $time)
                                                <option value="{{ $time->format('H:i') }}" {{ $time->eq($end_time) ? 'selected' : '' }}>{{ $time->format('H:i') }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-start"></th>
                                    <td>
                                        <input type="checkbox" id="absence" name="absence" value="absence" {{ $attendance->attended ? '' : 'checked' }}>
                                        <label for="absence">休業にする</label>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-start">備考</th>
                                    <td>
                                        <textarea name="comment" id="comment" cols="30" rows="4">{{ $attendance->comment }}</textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <input type="hidden" name="date" value="{{ $dt }}">
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            更新
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
let start_time = document.getElementById('start_time');
let end_time = document.getElementById('end_time');
let absence = document.getElementById('absence');

function specifyTime() {
    if (absence.checked) {
        start_time.disabled = true;
        end_time.disabled = true;
    } else {
        start_time.disabled = false;
        end_time.disabled = false;
    }
}

absence.addEventListener('change', specifyTime);
</script>
@endsection
