@extends('layouts.admin.master')

@section('title')
Add State
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}" />
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
@endsection
@section('content')
<div class="row justify-content-center align-items-center m-0">
    <div class="row">
        @if (session('status'))
            <h5 class="alert alert-danger">{{session('status')}}</h5>
        @endif
    </div>
    <div class="wrapper fadeInDown">
        <div id="formContent" class="pt-3 pb-2" style="margin-top: 120px;">
            <div class="fadeIn first my-2">
                {{ __('Add Country') }}
            </div>
            <form action="{{ route('Country.store') }}" method="post">
                @csrf
                <div class="form-group">
                    <input id="street" type="text" class="fadeIn first" placeholder="Country" name="country" autocomplete="none" autofocus>
                    @error('country')
                        <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
                <input type="submit" class="fadeIn fourth" value="{{ __('Submit') }}">
            </form>
        </div>
    </div>
</div>
@endsection
