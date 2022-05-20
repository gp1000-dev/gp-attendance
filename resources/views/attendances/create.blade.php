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
                                <tr>
                                    <th class="text-start">日付</th>
                                    @php
                                        $date = \Carbon\Carbon::today();
                                    @endphp
                                    <td>
                                        {{ $date->isoFormat('Y年M月D日（ddd）') }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-start">開始時刻</th>
                                    <td>
                                        <select id="start_time" name="start_time">
                                            <option value="13:00" selected>13:00</option>
                                            <option value="13:30">13:30</option>
                                            <option value="14:00">14:00</option>
                                            <option value="14:30">14:30</option>
                                            <option value="15:00">15:00</option>
                                            <option value="15:30">15:30</option>
                                            <option value="16:00">16:00</option>
                                            <option value="16:30">16:30</option>
                                            <option value="17:00">17:00</option>
                                            <option value="17:30">17:30</option>
                                            <option value="18:00">18:00</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-start">終了時刻</th>
                                    <td>
                                        <select id="end_time" name="end_time">
                                            <option value="13:00">13:00</option>
                                            <option value="13:30">13:30</option>
                                            <option value="14:00">14:00</option>
                                            <option value="14:30">14:30</option>
                                            <option value="15:00">15:00</option>
                                            <option value="15:30">15:30</option>
                                            <option value="16:00">16:00</option>
                                            <option value="16:30">16:30</option>
                                            <option value="17:00">17:00</option>
                                            <option value="17:30">17:30</option>
                                            <option value="18:00" selected>18:00</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-start"></th>
                                    <td>
                                        <input type="checkbox" id="absence" name="absence">
                                        <label for="absence">休業にする</label>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
