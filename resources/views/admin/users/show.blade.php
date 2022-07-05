@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            {{-- @if(session('flash_message'))
                <div class="alert alert-success">
                    {{ session('flash_message') }}
                </div>
            @endif --}}
            <div class="card">
                <div class="card-header">ユーザー情報</div>
                
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr><th>#</th><td>{{ $user->id }}</td></tr>
                            <tr><th>氏名</th><td>{{ $user->last_name }}&ensp;{{ $user->first_name }}</td></tr>
                            <tr><th>氏名カナ</th><td>{{ $user->last_kana_name }}&ensp;{{ $user->first_kana_name }}</td></tr>
                            <tr><th>性別</th><td>
                                @if ($user->gender === 'male')
                                    男性
                                @else
                                    女性
                                @endif
                            </td></tr>
                            <tr><th>誕生日</th><td>{{ $user->birthdate->format('Y年n月j日') }}({{$user->birthdate->age}}歳)</td></tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer d-flex justify-content-end">
            
                    <a href="{{ route('admin.users.index') }}" class="btn btn-primary">変更</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
