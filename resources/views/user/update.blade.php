@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $message)
                            <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card">
                <form method="POST" action="{{ route('user.update') }}">
                    @csrf

                    <div class="card-header">ユーザー情報変更</div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th class="align-middle">氏名</th>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" name="last_name" value="{{ $user->last_name }}">
                                            </div>
                                            &ensp;
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" name="first_name" value="{{ $user->first_name }}">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="align-middle">氏名カナ</th>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" name="last_kana_name" value="{{ $user->last_kana_name }}">
                                            </div>
                                            &ensp;
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" name="first_kana_name" value="{{ $user->first_kana_name }}">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="align-middle">性別</th>
                                    <td>
                                        <input type="radio" name="gender" value="male" <?php echo  ($user->gender === 'male') ? 'checked' : '' ?>>男性
                                        &ensp;
                                        <input type="radio" name="gender" value="female" <?php echo ($user->gender === 'female') ? 'checked' : '' ?>>女性
                                    </td>
                                </tr>
                                <tr>
                                    <th class="align-middle">誕生日</th>
                                    <td>
                                        <select name="birthdate_year">
                                            @foreach (range(\Carbon\Carbon::now()->addYears(-60)->year, \Carbon\Carbon::now()->year) as $year)
                                                <option value="{{ $year }}" {{ intval($user->birthdate->format('Y')) === $year ? 'selected' : '' }}>{{ $year }}</option>
                                            @endforeach
                                        </select>
                                        年
                                        <select name="birthdate_month">
                                            @foreach (range(1, 12) as $month)
                                                <option value="{{ $month }}" {{ intval($user->birthdate->format('n')) === $month ? 'selected' : '' }}>{{ $month }}</option>
                                            @endforeach
                                        </select>
                                        月
                                        <select name="birthdate_day">
                                            @foreach (range(1, 31) as $day)
                                                <option value="{{ $day }}" {{ intval($user->birthdate->format('j')) === $day ? 'selected' : '' }}>{{ $day }}</option>
                                            @endforeach
                                        </select>
                                        日
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            変更
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
