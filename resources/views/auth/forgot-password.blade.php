@extends('layouts.admin.master')

@section('title')
Forgot Password
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
            Forgot Password
        </div>

        <!-- Login Form -->
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif

            <div class="form-group">
                <input id="email" type="email" class="fadeIn second @error('email') is-invalid @enderror" name="email"
                    placeholder="Email" required autocomplete="email" autofocus>

                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <input type="submit" class="fadeIn fourth" value="Submit">
        </form>
    </div>
</div>
@endsection
