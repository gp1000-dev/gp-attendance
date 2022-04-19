@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
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
                                                <input type="text" class="form-control" name="last_name" value="{{ $user->last_name }}" required>
                                            </div>
                                            &ensp;
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" name="first_name" value="{{ $user->first_name }}" required>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="align-middle">氏名カナ</th>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" name="last_kana_name" value="{{ $user->last_kana_name }}" required>
                                            </div>
                                            &ensp;
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" name="first_kana_name" value="{{ $user->first_kana_name }}" required>
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
                                        <select name="birthdate-year">
                                            <?php for ($i=\Carbon\Carbon::now()->addYears(-60)->year; $i<=\Carbon\Carbon::now()->year; $i++) { ?>
                                                <option value="<?php echo $i ?>" <?php if (intval($user->birthdate->format('Y')) === $i) { echo 'selected'; } ?>><?php echo $i ?></option>
                                            <?php } ?>
                                        </select>
                                        年
                                        <select name="birthdate-month">
                                            <?php for ($i=1; $i<=12; $i++) { ?>
                                                <option value="<?php echo $i ?>" <?php if (intval($user->birthdate->format('n')) === $i) { echo 'selected'; } ?>><?php echo $i ?></option>
                                            <?php } ?>
                                        </select>
                                        月
                                        <select name="birthdate-day">
                                            <?php for ($i=1; $i<=31; $i++) { ?>
                                                <option value="<?php echo $i ?>" <?php if (intval($user->birthdate->format('j')) === $i) { echo 'selected'; } ?>><?php echo $i ?></option>
                                            <?php } ?>
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
