@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- バリデーション時のエラーを報告 -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $message)
                                <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <!-- エラー発生でリダイレクトの時の報告 -->
                @if (session('warning'))
                    <div class="alert alert-danger">
                        {{ session('warning') }}
                    </div>
                @endif
                <div class="card">
                    <form method="POST" action="{{ route('user.update') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                        <div class="card-header">ユーザー情報変更</div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th class="align-middle">氏名</th>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-1">
                                                    <label class="form-label mt-2" for="last_name">姓</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" name="last_name">
                                                </div>
                                                <div class="col-md-1">
                                                    <label class="form-label mt-2" for="first_name">名</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" name="first_name">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="align-middle">氏名カナ</th>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-1">
                                                    <label class="form-label mt-2" for="last_kana_name">姓</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" name="last_kana_name">
                                                </div>
                                                <div class="col-md-1">
                                                    <label class="form-label mt-2" for="first_kana_name">名</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" name="first_kana_name">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="align-middle">性別</th>
                                        <td>
                                            <input type="radio" name="gender" value="male">男性
                                            &ensp;
                                            <input type="radio" name="gender" value="female">女性
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="align-middle">誕生日</th>
                                        <td>
                                            <select name="birthdate_year">
                                                <option value="--">--</option>
                                                @foreach (range(\Carbon\Carbon::now()->addYears(-60)->year, \Carbon\Carbon::now()->year) as $year)
                                                    <option value="{{ $year }}">
                                                        {{ $year }}</option>
                                                @endforeach
                                            </select>
                                            年
                                            <select name="birthdate_month">
                                                <option value="--">--</option>
                                                @foreach (range(1, 12) as $month)
                                                    <option value="{{ $month }}">>
                                                        {{ $month }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            月
                                            <select name="birthdate_day">
                                                <option value="--">--</option>
                                                @foreach (range(1, 31) as $day)
                                                    <option value="{{ $day }}">
                                                        {{ $day }}
                                                @endforeach
                                            </select>
                                            日
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="align-middle">メールアドレス</th>
                                        <td>
                                            <input type="email" class="form-control" name="email">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="align-middle">パスワード</th>
                                        <td>
                                            <input type="password" class="form-control" name="password">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="align-middle">パスワード(確認)</th>
                                        <td>
                                            <input type="password" class="form-control" name="password-confirm">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-between">
                                <a href="{{ Route('admin.users.index') }}" class="btn btn-secondary">戻る</a>
                                <a href="{{ Route('admin.users.store') }}" class="btn btn-primary">登録</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
