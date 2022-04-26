@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- バリデーションエラーの報告 -->
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $message)
                            <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <!-- エラー発生でリダイレクト時の報告 -->
            @if (session('warning'))
                <div class="alert alert-danger">
                    {{ session('warning') }}
                </div>
            @endif
            <div class="card">
                <form method="POST" action="{{ route('update.password') }}">
                    @csrf
                    <input type="hidden" name="id" value="{{ Auth::user()->id }}">

                    <div class="card-header">パスワード変更</div>

                    <div class="card-body">
                        <div class="row mb-3">
                            <label for="password" class="col-md-6 col-form-label text-md-start">現在のパスワード</label>

                            <div class="col-md-5">
                                <input id="password" type="password" class="form-control" name="password">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="new_password" class="col-md-6 col-form-label text-md-start">新しいパスワード</label>

                            <div class="col-md-5">
                                <input id="new_password" type="password" class="form-control" name="new_password">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="new_password_confirm" class="col-md-6 col-form-label text-md-start">新しいパスワード（確認）</label>

                            <div class="col-md-5">
                                <input id="new_password_confirm" type="password" class="form-control" name="new_password_confirmation">
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
