@extends('layouts.admin.master')

@section('title')
    Add User
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
@endsection

@section('content')
<div class="wrapper fadeInDown">
    <div id="formContent" style="margin: 100px 0">
        <!-- Tabs Titles -->

        <!-- Icon -->
        <div class="fadeIn first my-2">
            @isset($email_error)
                <p class="alert alert-danger">{{$email_error}}</p>
            @endisset
            {{ __('Add user') }}
        </div>

        <!-- Login Form -->
        <form method="POST" action="{{route('useradd')}}">
            @csrf
            <div class="form-group">
                <input id="name" type="text" class="fadeIn second @error('name') is-invalid @enderror"
                    placeholder="Name" name="name" value="{{ old('name') }}" a autocomplete="name" autofocus>

                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <input id="email" type="email" class="fadeIn second @error('email') is-invalid @enderror" name="email"
                    placeholder="Email" value="{{ old('email') }}" edw autocomplete="email">
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <input id="password" type="password" class="fadeIn third @error('password') is-invalid @enderror"
                    placeholder="Password" name="password"  autocomplete="new-password">
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <input id="password-confirm" type="password" class="fadeIn third" name="password_confirmation"
                    autocomplete="new-password" placeholder="Confirm Password">
            </div>
            <div class="form-group">
                <select class="fadeIn @error('user_type_id') is-invalid @enderror" name="user_type_id"  id="user_type">
                    <option selected disabled>User Type</option>
                @isset($user_type)
                    @foreach ($user_type as $item)
                        <option class="text-capitalize" value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                @endisset
                </select>
                @error('user_type_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <input id="mobile" type="text" class="fadeIn third" name="mobile"
                    autocomplete="Mobile" placeholder="Mobile">
            </div>
            <div class="form-group">
                <input id="address" type="text" class="fadeIn third" name="address"
                    autocomplete="Address" placeholder="Address">
            </div>
            <input type="submit" class="fadeIn fourth" value="{{ __('Register') }}">
        </form>
    </div>
</div>
@endsection
