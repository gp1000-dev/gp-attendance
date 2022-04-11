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
            <a href="{{ url('/about') }}">システムについて</a>
        <div>
        <div class="col-md-8">
            <a href="{{ url('/login') }}">ログインはこちら</a>
        <div>
        <div class="col-md-8">
            <a href="{{ url('/register') }}">新規ユーザー登録はこちら</a>
        <div>
        <div class="col-md-8">
            <a href="{{ url('https://gp1000.jp/') }}" target="_blank" rel="noopener noreferrer">GIFT PLACEはこちら</a>
        <div>
    <div>
</div>
@endsection
