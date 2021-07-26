@extends('layouts.admin.master')
@section('title')
Reset Password
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}" />
@endsection
@section('content')
<div class="wrapper fadeInDown">
    <div id="formContent">
        <!-- Tabs Titles -->

        <!-- Icon -->
        <div class="fadeIn first my-2">
            Password Reset
        </div>

        <!-- Login Form -->
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <div class="form-group">
                <input type="hidden" name="token" value="{{ $token}}">
                <input id="email" type="hidden" name="email" value="{{$email}}">
                    <input id="password" type="password"
                        class="fadeIn second @error('password') is-invalid @enderror" name="password"
                        required placeholder="New Password" autocomplete="new-password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
            </div>

            <div class="form-group">
                    <input id="password-confirm" type="password" class="fadeIn third"
                        name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password">
            </div>
            <input type="submit" class="fadeIn fourth" value="Reset">
        </form>
    </div>
</div>

@endsection
