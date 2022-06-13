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
                <form method="POST" action="{{ route('attendances.update') }}">
                    @csrf

                    <div class="card-header">勤怠編集</div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tbody>
                                @php
                                    $defaultStartTime = config('app.attendance.default_start_time');
                                    $defaultEndTime = config('app.attendance.default_end_time');
                                    $minStartTime = config('app.attendance.min_start_time');
                                    $maxEndTime = config('app.attendance.max_end_time');
                                    $timeDuration = \Carbon\Carbon::create(config('app.attendance.time_duration'));
                                    $timeDurationMinutes = $timeDuration->hour * 60 + $timeDuration->minute;

                                    $period = \Carbon\CarbonPeriod::create($minStartTime, $maxEndTime)->minutes($timeDurationMinutes)->toArray();
                                    $start_time = is_null($attendance->start_time) ? \Carbon\Carbon::create($defaultStartTime) : $attendance->start_time;
                                    $end_time = is_null($attendance->end_time) ? \Carbon\Carbon::create($defaultEndTime) : $attendance->end_time;
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
                    <div class="card-footer d-flex justify-content-between">
                        <button type="submit" name="update" class="btn btn-primary">
                            変更
                        </button>
                        <button type="submit" name="reset" class="btn btn-primary">
                            取消
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
