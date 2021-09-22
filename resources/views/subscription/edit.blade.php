@extends('layouts.admin.master')

@section('title')
Edit Subscription
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}" />
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
@endsection

@section('content')
<div class="wrapper fadeInDown">
    <div id="formContent" class="pt-3 pb-2" style="margin: 100px;">
        <div class="fadeIn first my-2">
            @if (session('status'))
                <div class="alert alert-danger">
                    <h3 class="text-danger">{{session('status')}}</h3>
                </div>
            @endif
            {{ __('Edit Subscription') }}
        </div>
        <!-- add subscription -->
        <form method="POST"  action="{{ route('subsUpdate') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{$id}}">
            <div class="form-group">
                <input id="name" type="text" class="fadeIn second @error('name') is-invalid @enderror"
                    placeholder="Name" name="name" autocomplete="name" value="{{$subscription->name}}"
                    autofocus>

                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <select name="type" id="type" class="fadeIn second @error('type') is-invalid @enderror">
                    <option selected disabled>Type</option>
                        @if ($subscription->type == "days")
                            <option selected value="days">Days</option>
                        @else
                            <option value="days">Days</option>
                        @endif
                        @if ($subscription->type == "month")
                        <option selected value="month">Month</option>
                        @else
                        <option value="month">Month</option>
                        @endif
                    <option value="month">Month</option>
                </select>
                @error('type')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <input id="period" type="text" class="fadeIn second @error('period') is-invalid @enderror"
                    placeholder="Period" name="period" autocomplete="period" value="{{$subscription->period}}"
                    autofocus>

                @error('period')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <input id="amount" type="text" class="fadeIn second @error('amount') is-invalid @enderror"
                    placeholder="Amount" name="amount" autocomplete="amount" value="{{$subscription->amount}}"
                    autofocus>
                @error('amount')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <input id="feature" type="text" class="fadeIn second @error('feature') is-invalid @enderror"
                    placeholder="feature" name="feature" autocomplete="feature" value="{{$subscription->feature}}"
                    autofocus>
                <small class="form-text text-muted">This feild is not required</small>
                @error('feature')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <input type="submit" class="fadeIn fourth" value="{{ __('Update') }}">
    </div>
</div>
@endsection
@section('js')
@endsection
