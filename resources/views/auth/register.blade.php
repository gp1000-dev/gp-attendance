@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="last_name" class="col-md-4 col-form-label text-md-end">氏名</label>

                            <div class="col-md-2">
                                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" {{-- required --}} autocomplete="last_name" autofocus>

                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            &ensp;
                            <div class="col-md-2">
                                <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" {{-- required --}} autocomplete="first_name">

                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="last_kana_name" class="col-md-4 col-form-label text-md-end">氏名カナ</label>

                            <div class="col-md-2">
                                <input id="last_kana_name" type="text" class="form-control @error('last_kana_name') is-invalid @enderror" name="last_kana_name" value="{{ old('last_kana_name') }}" {{-- required --}} autocomplete="last_kana_name">

                                @error('last_kana_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            &ensp;
                            <div class="col-md-2">
                                <input id="first_kana_name" type="text" class="form-control @error('first_kana_name') is-invalid @enderror" name="first_kana_name" value="{{ old('first_kana_name') }}" {{-- required --}} autocomplete="first_kana_name">

                                @error('first_kana_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" {{-- required --}} autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" {{-- required --}} autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" {{-- required --}} autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">性別</label>

                            <div class="col-md-6">
                                <div class="form-check">
                                    <input id="male" type="radio" class="form-check-input @error('gender') is-invalid @enderror" name="gender" value="male">
                                    <label class="form-check-label" for="male">男性</label>
                                </div>
                                <div class="form-check">
                                    <input id="female" type="radio" class="form-check-input @error('gender') is-invalid @enderror" name="gender" value="female">
                                    <label class="form-check-label" for="female">女性</label>

                                    @error('gender')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">誕生日</label>

                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4">
                                        <select name="birthdate_year" class="form-select @error('birthdate_year') is-invalid @enderror">
                                            <option value="">----</option>
                                            @foreach (range(\Carbon\Carbon::now()->addYears(-60)->year, \Carbon\Carbon::now()->year) as $year)
                                                <option value="{{ $year }}" {{ $year === (int)old('birthdate_year') ? 'selected' : '' }}>{{ $year }}</option>
                                            @endforeach
                                        </select>

                                        @error('birthdate_year')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    年
                                    <div class="col-md-3">
                                        <select name="birthdate_month" class="form-select @error('birthdate_month') is-invalid @enderror">
                                            <option value="">--</option>
                                            @foreach (range(1, 12) as $month)
                                                <option value="{{ $month }}" {{ $month === (int)old('birthdate_month') ? 'selected' : '' }}>{{ $month }}</option>
                                            @endforeach
                                        </select>

                                        @error('birthdate_month')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    月
                                    <div class="col-md-3">
                                        <select name="birthdate_day" class="form-select @error('birthdate_day') is-invalid @enderror">
                                            <option value="">--</option>
                                            @foreach (range(1, 31) as $day)
                                                <option value="{{ $day }}" {{ $day === (int)old('birthdate_day') ? 'selected' : '' }}>{{ $day }}</option>
                                            @endforeach
                                        </select>

                                        @error('birthdate_day')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    日
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
