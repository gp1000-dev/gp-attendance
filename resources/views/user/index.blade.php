@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">ユーザー情報</div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr><th>氏名</th><td>{{ Auth::user()->last_name }}&ensp;{{ Auth::user()->first_name }}</td></tr>
                            <tr><th>氏名カナ</th><td>{{ Auth::user()->last_kana_name }}&ensp;{{ Auth::user()->first_kana_name }}</td></tr>
                            <tr><th>性別</th><td>
                                <?php if (Auth::user()->gender === 'male'): ?>
                                    男性
                                <?php else: ?>
                                    女性
                                <?php endif; ?>
                            </td></tr>
                            <tr><th>誕生日</th><td>{{ Auth::user()->birthdate->format('Y年n月j日') }}</td></tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <a href="#">ユーザー情報変更</a>
                    <a href="#">パスワード変更</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
