@extends('layouts.admin.master')

@section('title')
Edit Property Address
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}" />
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
@endsection
@section('content')
<div class="row justify-content-center align-items-center m-0">
    <div class="wrapper fadeInDown">
        <div id="formContent" class="pt-3 pb-2" style="margin-top: 120px;">
            <div class="fadeIn first my-2">
                {{ __('Property Address') }}
            </div>
            <div class="form-group">
                <div class="form-inline justify-content-center">
                    <input type="text" class="fadeIn px-1" placeholder="City" autocomplete="none" name="city" id="city"
                        style="width: 185px">
                    <input type="text" class="fadeIn px-1" placeholder="State" autocomplete="none" name="state"
                        id="state" style="width: 185px">
                </div>
                <div class="text-danger" id="city_sate-span"></div>
            </div>
            <div class="form-group">
                <input id="street" type="text" placeholder="Street" name="street" autocomplete="none" autofocus>
                <div class="text-danger" id="street-span"></div>
            </div>
            <div class="form-group">
                <input id="zipcode" type="text" placeholder="Zip code" name="zip_code" autocomplete="none" autofocus>
                <div class="text-danger" id="zipcode-span"></div>
            </div>
            <input id="second" type="button" class="fadeIn fourth" value="{{ __('Next') }}">
        </div>
    </div>
</div>
@endsection
