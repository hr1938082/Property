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
    <div class="wrapper fadeInDown align-items-center" style="height: 100vh">
        <div id="formContent" class="pt-3 pb-2">
            <div class="fadeIn first">
                @if (session('status'))
                <h4 class="alert alert-success">
                    {{session('status')}}
                </h4>
                @endif
                {{ __('Property Information') }}
            </div>
            <form action="{{ route('updateinfo') }}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{$id}}">
                <div class="form-group">
                    <input id="name" type="text" class="fadeIn first
                        @error('property_name')
                            {{"border border-danger"}}
                        @enderror
                    " placeholder="Name" name="property_name" autocomplete="off" autofocus
                        value="<?php echo $property->property_name?>">
                    @error('property_name')
                    <div class="text-danger">
                        {{"Property name invalid"}}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <div class="form-inline justify-content-center">
                        <select class="fadeIn second px-1
                            @error('bed_rooms')
                                {{"border border-danger"}}
                            @enderror
                        " name="bed_rooms" id="bed_rooms" style="width: 130px">
                            <option selected disabled>Bed Rooms</option>
                            @for ($i = 1; $i < 4; $i++) @if ($property->bed_rooms == $i)

                                <option selected class="text-capitalize" value="{{$i}}">{{$i}}</option>
                                @else
                                <option class="text-capitalize" value="{{$i}}">{{$i}}</option>
                                @endif
                                @endfor
                        </select>
                        <select class="fadeIn second px-1
                        @error('bed_rooms')
                            {{"border border-danger"}}
                        @enderror
                        " name="bath_rooms" id="bath_rooms" style="width: 135px">
                            <option selected disabled>Bath Rooms</option>
                            @for ($i = 1; $i < 4; $i++) @if ($property->bath_rooms == $i)
                                <option selected class="text-capitalize" value="{{$i}}">{{$i}}</option>
                                @else
                                <option class="text-capitalize" value="{{$i}}">{{$i}}</option>
                                @endif
                                @endfor
                        </select>
                    </div>
                    <div class="text-danger">
                        @error('bed_rooms')
                        {{"select a valid bedroom number"}}
                        @enderror
                        @error('bath_rooms')
                        {{"select a valid bathroom number"}}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <textarea autocomplete="none" type="text" class="fadeIn third shadow-none
                        @error('description')
                            {{"border border-danger"}}
                        @enderror
                    " placeholder="Description" name="description">{{$property->description}}</textarea>
                    <div class="text-danger" id="description-span">
                        @error('description')
                        {{"description is required"}}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-inline justify-content-center">
                        <div style="width: 190px">
                            <select class="fadeIn third
                                @error(" currency_id") {{"border border-danger"}} @enderror " name=" currency_id"
                                id="currency_id">
                                <option selected disabled>currency</option>
                                @foreach ($currency as $item)
                                @if ($item->id == $property->currency_id)
                                <option selected value="{{$item->id}}">{{$item->currency}}</option>
                                @else
                                <option value="{{$item->id}}">{{$item->currency}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <div style="width: 190px">
                            <input id="Rent" type="text" class="fadeIn third
                                @error(" rent") {{"border border-danger"}} @enderror " name=" rent" placeholder="Rent"
                                autocomplete="none" value="<?php echo $property->rent?>">
                        </div>
                        <div class="text-danger" id="Rent-span">
                            @error("currency_id")
                            {{"Currency is required"}}
                            @enderror
                            @error("rent")
                            {{"rent is required"}}
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <select class="fadeIn third px-1" name="user_id" id="users" style="width: 355px">
                        <option selected disabled>User</option>
                        @foreach ($users as $item)
                        @if ($property->user_id === $item->id)
                        <option selected value="{{$item->id}}">{{$item->name}}s</option>
                        @else
                        <option value="{{$item->id}}">{{$item->name}}s</option>
                        @endif
                        @endforeach
                    </select>
                    <div class="text-danger" id="user-span">
                        @error("user_id")
                            {{"User is required"}}
                            @enderror
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-inline justify-content-center">
                        <div style="width: 190px">
                            <input id="rent_days" type="text" class="fadeIn third" name="rent_days"
                                placeholder="Rent Days" autocomplete="none" value="{{$property->rent_days}}">
                        </div>
                        <div style="width: 190px">
                            <input id="property_limit" type="text" class="fadeIn third" name="limit" placeholder="Limit"
                                autocomplete="none" value="{{$property->property_limit}}">
                        </div>
                    </div>
                    <div class="text-danger" id="rent-limit-span">
                        @error("rent_days")
                        {{"Rent Days is required"}}
                        @enderror
                        @error("limit")
                        {{"Limit is required"}}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>Year Build</label>
                    <div class="form-inline justify-content-center">
                        <select class="fadeIn fourth px-1 rounded-0 m-0
                            @error('build_year')
                                {{"border border-danger"}}
                            @enderror
                        " name="build_date" id="build_date"
                            style="width: 70px; border-top-left-radius: 5px !important;border-bottom-left-radius: 5px !important;">
                            <option selected disabled>Date</option>
                            @for ($i = 1; $i <= 31; $i++) @if ($i==(int)Str::substr($property->year_build, 8))
                                <option selected value="{{$i}}">{{$i}}</option>
                                @else
                                <option value="{{$i}}">{{$i}}</option>
                                @endif
                                @endfor
                        </select>
                        <select class="fadeIn fourth px-1 rounded-0 m-0
                            @error(" build_month") {{"border border-danger"}} @enderror " name=" build_month"
                            id="build_month" style="width: 90px">
                            <option selected disabled>Month</option>
                            @for ($i = 1; $i <= 12; $i++) @if ($i==(int)Str::substr($property->year_build, 5,2))
                                <option selected value="{{$i}}">{{$i}}</option>
                                @else
                                <option value="{{$i}}">{{$i}}</option>
                                @endif
                                @endfor
                        </select>
                        @php
                        $year = (int)date('Y');
                        @endphp
                        <select class="fadeIn fourth px-1 rounded-0 m-0
                            @error(" build_year") {{"border border-danger"}} @enderror " name=" build_year"
                            id="build_year" style="width: 90px">
                            <option selected disabled>Year</option>

                            @for ($i = $year; $i >= $year-100; $i--)
                            @if ($i == (int)Str::substr($property->year_build, 0,4))
                            <option selected value="{{$i}}">{{$i}}</option>
                            @else
                            <option value="{{$i}}">{{$i}}</option>
                            @endif
                            @endfor
                        </select>
                    </div>
                    <div class="text-danger" id="year_build"></div>
                </div>
                <input id="first" type="submit" class="fadeIn fourth" value="{{ __('Submit') }}">
            </form>
        </div>
    </div>
</div>
@endsection
