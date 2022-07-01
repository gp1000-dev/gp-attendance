@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">ユーザー一覧</div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ユーザー名</th>
                                <th>性別</th>
                                <th>誕生日</th>
                                <th>メール</th>
                                <th></th>
                            </tr>
                            @php
                            use Carbon\Carbon;
                            @endphp
                            @foreach($users as $user)
                            <tr>
                                <td>{{$user->id}}</td>
                                <td>{{ $user->last_name }}&ensp;{{ $user->first_name }}</td>
                                <td>
                                    @if ($user->gender === 'male')
                                        男性
                                    @else
                                        女性
                                    @endif
                                </td>
                                <td>{{$user->birthdate->format('Y年n月j日')}}({{$user->birthdate->age}}歳)</td>
                                <td>{{$user->email}}</td>
                                <td></td>
                            </tr>
                            @endforeach
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
