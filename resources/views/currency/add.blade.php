@extends('layouts.admin.master')

@section('title')
    Add Currency
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
@endsection

@section('content')
<div class="wrapper fadeInDown">
    <div id="formContent" style="margin: 150px 0 0 0">
        <!-- Tabs Titles -->

        <!-- Icon -->
        <div class="fadeIn first my-2">
            @if (session('status'))
                <h4 class="alert alert-danger">{{session('status')}}</h4>
            @endif
            {{ __('Add Currency') }}
        </div>

        <!-- Login Form -->
        <form method="POST" action="{{ route('currencyInsert') }}">
            @csrf
            <div class="form-group">
                <input id="currency" type="text" class="fadeIn second @error('currency') is-invalid @enderror"
                    placeholder="Currency" name="currency" value="{{ old('currency') }}" a autocomplete="name" autofocus>

                @error('currency')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <input type="submit" class="fadeIn fourth" value="{{ __('Submit') }}">
        </form>
    </div>
</div>
@endsection
