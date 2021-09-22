@extends('layouts.admin.master')

@section('title')
Reset Password
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
<link rel="stylesheet" href="{{ asset('css/auth.css') }}" />
@endsection

@section('content')
<div class="wrapper fadeInDown">
    <div id="formContent" style="margin-top: 70px;">
        <!-- Tabs Titles -->

        <!-- Icon -->
        <div class="fadeIn first my-2">
            Change Password
        </div>

        <!-- Login Form -->
        <form method="POST" action="{{ route('user-password.update') }}">
            @csrf
            @method('PUT')
            @if (session('status') =="password-updated")
            <div class="alert alert-success" role="alert">
                {{ "Password Changed" }}
            </div>
            @endif
            <div class="form-group">
                <input id="current_password" type="password" class="fadeIn second @error('current_password','updatePassword') is-invalid @enderror"
                    name="current_password" required placeholder="Current Password" autocomplete="new-password">
                @error('current_password','updatePassword')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <input id="password" type="password" class="fadeIn second @error('password','updatePassword') is-invalid @enderror"
                    name="password" required placeholder="Password" autocomplete="new-password">
                @error('password','updatePassword')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <input id="password-confirm" type="password" class="fadeIn third" name="password_confirmation"
                    placeholder="Confirm Password" required autocomplete="new-password">
            </div>
            <input type="submit" class="fadeIn fourth" value="Submit">
        </form>
    </div>
</div>

@endsection
