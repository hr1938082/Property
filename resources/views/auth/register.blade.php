@extends('layouts.admin.master')

@section('title')
Signup
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}" />
@endsection
@section('content')
<div class="wrapper fadeInDown">
    <div id="formContent" class="my-5">
        <!-- Tabs Titles -->

        <!-- Icon -->
        <div class="fadeIn first my-2">
            {{ __('Register') }}
        </div>

        <!-- Login Form -->
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <input id="name" type="text" class="fadeIn second @error('name') is-invalid @enderror"
                    placeholder="Name" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <input id="email" type="email" class="fadeIn second @error('email') is-invalid @enderror" name="email"
                    placeholder="Email" value="{{ old('email') }}" required autocomplete="email">
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <input id="password" type="password" class="fadeIn third @error('password') is-invalid @enderror"
                    placeholder="Password" name="password" required autocomplete="new-password">
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <input id="password-confirm" type="password" class="fadeIn third" name="password_confirmation" required
                    autocomplete="new-password" placeholder="Confirm Password">
            </div>
            <div class="form-group">
                @isset($user_type)
                <select class="fadeIn third @error('user_type_id') is-invalid @enderror" name="user_type_id" required id="user_type">
                    <option selected disabled>User Type</option>
                    @foreach ($user_type as $item)
                    <option class="text-capitalize" value="{{$item->id}}">{{$item->name}}</option>    
                    @endforeach
                </select>
                @endisset
                @error('user_type_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <input id="mobile" type="text" class="fadeIn third" name="mobile" required
                    autocomplete="Mobile" placeholder="Mobile">
            </div>
            <div class="form-group">
                <input id="address" type="text" class="fadeIn third" name="address" required
                    autocomplete="Address" placeholder="Address">
            </div>
            <input type="submit" class="fadeIn fourth" value="{{ __('Register') }}">
        </form>
    </div>
</div>
@endsection
