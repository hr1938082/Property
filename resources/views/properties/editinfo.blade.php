@extends('layouts.admin.master')

@section('title')
Edit Property Info
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
                {{ __('Property Information') }}
            </div>
            <div class="form-group">
                <input id="name" type="text" class="fadeIn second" placeholder="Name" name="property_name"
                    autocomplete="off" autofocus>
                <div class="text-danger" id="name-span"></div>
            </div>
            <div class="form-group">
                <div class="form-inline justify-content-center">
                    <select class="fadeIn px-1" name="bed_rooms" id="bed_rooms" style="width: 130px">
                        <option selected disabled>Bed Rooms</option>
                        <option class="text-capitalize" value="1">1</option>
                        <option class="text-capitalize" value="2">2</option>
                        <option class="text-capitalize" value="3">3</option>
                    </select>
                    <select class="fadeIn px-1" name="bath_rooms" id="bath_rooms" style="width: 135px">
                        <option selected disabled>Bath Rooms</option>
                        <option class="text-capitalize" value="1">1</option>
                        <option class="text-capitalize" value="2">2</option>
                        <option class="text-capitalize" value="3">3</option>
                    </select>
                </div>
                <div class="text-danger" id="room-span"></div>
            </div>
            <div class="form-group">
                <textarea id="description" autocomplete="none" type="text" class="fadeIn third shadow-none"
                    placeholder="Description" name="description"></textarea>
                <div class="text-danger" id="description-span"></div>
            </div>
            <div class="form-group">
                <div class="form-inline justify-content-center">
                    <div style="width: 190px">
                        <select class="fadeIn" name="currency_id" id="currency_id">
                            <option selected disabled>currency</option>
                        </select>
                    </div>
                    <div style="width: 190px">
                        <input id="Rent" type="text" class="fadeIn third" name="rent" placeholder="Rent"
                            autocomplete="none">
                    </div>
                    <div class="text-danger" id="Rent-span"></div>
                </div>
            </div>
            <div class="form-group">
                <label>Year Build</label>
                <div class="form-inline justify-content-center">
                    <select class="fadeIn third px-1 rounded-0 m-0" name="build_date" id="build_date"
                        style="width: 70px; border-top-left-radius: 5px !important;border-bottom-left-radius: 5px !important;">
                        <option selected disabled>Date</option>
                        @for ($i = 1; $i <= 31; $i++) <option value="{{$i}}">{{$i}}</option>
                            @endfor
                    </select>
                    <select class="fadeIn third px-1 rounded-0 m-0" name="build_month" id="build_month"
                        style="width: 90px">
                        <option selected disabled>Month</option>
                        @for ($i = 1; $i <= 12; $i++) <option value="{{$i}}">{{$i}}</option>
                            @endfor
                    </select>
                    <select class="fadeIn third px-1 rounded-0 m-0" name="build_year" id="build_year"
                        style="width: 90px">
                        <option selected disabled>Year</option>
                    </select>
                </div>
                <div class="text-danger" id="year_build"></div>
            </div>
            <input id="first" type="button" class="fadeIn fourth" value="{{ __('Next') }}">
        </div>
    </div>
</div>
@endsection
