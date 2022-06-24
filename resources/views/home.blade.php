@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <?php

             ?>

            <h2>{{$user->last_name}} {{$user->first_name}} さん こんにちは！</h2>
            
            <ul>
                <li><a href="/user">ユーザー情報</a></li>
                <li><a href="/attendances">勤怠情報</a></li>
            </ul>

        </div>
    </div>
</div>
@endsection
