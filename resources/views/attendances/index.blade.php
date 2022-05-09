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

                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <a href="{{ route('user.edit') }}">ユーザー情報変更</a>
                    <a href="{{ route('user.password.edit') }}">パスワード変更</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
