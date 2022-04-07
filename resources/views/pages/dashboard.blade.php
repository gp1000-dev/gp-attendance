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
    <div>
</div>
@endsection
