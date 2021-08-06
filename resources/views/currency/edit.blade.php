@extends('layouts.admin.master')

@section('title')
    Edit Currency
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
            {{ __('Edit Currency') }}
        </div>

        <!-- Login Form -->
        <form method="POST" action="{{ route('currencyUpdate') }}">
            @csrf
            <input type="hidden" name="id" value="{{$id}}">
            <div class="form-group">
                <input id="currency" type="text" class="fadeIn second @error('currency') is-invalid @enderror"
                    placeholder="Currency" name="currency" value="{{$currency->currency}}" a autocomplete="name" autofocus>

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
