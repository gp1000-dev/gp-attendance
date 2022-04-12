@extends('layouts.app')
@section('title', 'ダッシュボード')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h1>ダッシュボード</h1>
        <div>
    <div>
    <div class="row">
        <div class="col-md-8">
            <ul class="list-unstyled">
                <li>
                    <a href="{{ url('/about') }}">システムについて</a>
                </li>
                <li>
                    <a href="{{ url('/login') }}">ログインはこちら</a>
                </li>
                <li>
                    <a href="{{ url('/register') }}">新規ユーザー登録はこちら</a>
                </li>
                <li>
                    <a href="{{ url('https://gp1000.jp/') }}" target="_blank" rel="noopener noreferrer">GIFT PLACEはこちら</a>
                </li>
            </ul>
        <div>
    <div>
</div>
@endsection
