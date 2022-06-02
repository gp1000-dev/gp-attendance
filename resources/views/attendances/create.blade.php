@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <form method="POST" action="{{ route('attendances.store') }}">
                    @csrf

                    <div class="card-header">勤怠入力</div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tbody>
                                @php
                                    $period = \Carbon\CarbonPeriod::create('09:00:00', '18:00:00')->minutes(30)->toArray();
                                @endphp
                                <tr>
                                    <th class="text-start">日付</th>
                                    <td>
                                        {{ $dt->isoFormat('Y年M月D日（ddd）') }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-start">開始時刻</th>
                                    <td>
                                        <select id="start_time" name="start_time">
                                            @foreach ($period as $time)
                                                <option value="{{ $time->format('H:i') }}" {{ $time->eq(\Carbon\Carbon::create('13:00:00')) ? 'selected' : '' }}>{{ $time->format('H:i') }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-start">終了時刻</th>
                                    <td>
                                        <select id="end_time" name="end_time">
                                            @foreach ($period as $time)
                                                <option value="{{ $time->format('H:i') }}" {{ $time->eq(\Carbon\Carbon::create('18:00:00')) ? 'selected' : '' }}>{{ $time->format('H:i') }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-start"></th>
                                    <td>
                                        <input type="checkbox" id="absence" name="absence" value="absence">
                                        <label for="absence">休業にする</label>
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
