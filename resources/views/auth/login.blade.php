@extends('layouts.admin.master')
@section('title')
Login
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}" />
@endsection
@section('content')
<div class="wrapper fadeInDown">
    @if (session('status'))
        <h3 class="alert alert-danger">{{session('status')}}</h3>
    @endif
    <div id="formContent">
        <!-- Tabs Titles -->

        <!-- Icon -->
        <div class="fadeIn first my-2">
            Login
        </div>

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <input id="login" type="email" class="fadeIn second @error('email') is-invalid @enderror" name="email"
                    value="{{ old('email') }}" placeholder="Email" required autocomplete="email" autofocus>

                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                    <input type="password" class="fadeIn third @error('password') is-invalid @enderror"
                    name="password" placeholder="password" required>
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <input type="submit" class="fadeIn fourth" value="Log In">
        </form>

        <!-- Remind Passowrd -->
        @if (Route::has('password.request'))
            <div id="formFooter">
                <a class="underlineHover" href="{{ route('password.request') }}">Forgot Password?</a>
            </div>
        @endif

    </div>
</div>
@endsection
