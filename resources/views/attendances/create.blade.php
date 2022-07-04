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
                <form method="POST" action="{{ route('attendances.store') }}">
                    @csrf

                    <div class="card-header">勤怠入力</div>
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
                                @endphp
                                <tr>
                                    <th class="text-start">日付</th>
                                    <td>
                                        {{ $dt->copy()->isoFormat('Y年M月D日（ddd）') }}
                                    </td>
                                </tr>
                                <th>状態</th>
                                <td>
                                    <select id="status" name="status">
                                        <option value="" selected>--</option>
                                        <option value="full">出勤（全日）</option>
                                        <option value="half">出勤（半日）</option>
                                        <option value="off">休業</option>
                                    </select>
                                <tr>
                                    <th class="text-start">開始時刻</th>
                                    <td>
                                        <select id="start_time" name="start_time">
                                            @foreach ($period as $time)
                                                <option value="{{ $time->format('H:i') }}" {{ $time->eq(\Carbon\Carbon::create($defaultStartTime)) ? 'selected' : '' }}>{{ $time->format('H:i') }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-start">終了時刻</th>
                                    <td>
                                        <select id="end_time" name="end_time">
                                            @foreach ($period as $time)
                                                <option value="{{ $time->format('H:i') }}" {{ $time->eq(\Carbon\Carbon::create($defaultEndTime)) ? 'selected' : '' }}>{{ $time->format('H:i') }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-start">備考</th>
                                    <td>
                                        <textarea name="comment" id="comment" cols="30" rows="4"></textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <input type="hidden" name="date" value="{{ $dt }}">
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            登録
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
$(() => {
    $('#status').change(() => {
        if ($('#status').val() == 'off') {
            $('#start_time').prop('disabled', true);
            $('#end_time').prop('disabled', true);
        } else {
            $('#start_time').prop('disabled', false);
            $('#end_time').prop('disabled', false);
        }
    });
});
</script>
@endsection
