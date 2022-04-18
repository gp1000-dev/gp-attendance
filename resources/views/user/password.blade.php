@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <form method="POST" action="{{ route('password.change') }}">
                    @csrf

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="card-header">パスワード変更</div>

                    <div class="card-body">
                        <div class="row mb-3">
                            <label for="password" class="col-md-6 col-form-label text-md-start">現在のパスワード</label>

                            <div class="col-md-5">
                                <input id="password" type="password" class="form-control" name="password" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="new-password" class="col-md-6 col-form-label text-md-start">新しいパスワード</label>

                            <div class="col-md-5">
                                <input id="new-password" type="password" class="form-control" name="new-password" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="new-password-confirm" class="col-md-6 col-form-label text-md-start">新しいパスワード（確認）</label>

                            <div class="col-md-5">
                                <input id="new-password-confirm" type="password" class="form-control" name="new-password_confirmation" required>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            変更する
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
