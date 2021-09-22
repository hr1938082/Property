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
                {{ __('Owner Details') }}
            </div>
            <form action="{{ route('adds.updateowner') }}" method="post">
                @csrf
                <div class="form-group">
                    <input type="hidden" name="id" value="{{$id}}">
                    <input id="owner_name" type="text" value="{{$ads_owner->owner}}" placeholder="Name" name="owner_name" autocomplete="none">
                    <div class="text-danger" id="owner_name-span"></div>
                </div>
                <div class="form-group">
                    <input id="owner_email" type="text" placeholder="Email" value="{{$ads_owner->owner_email}}" name="owner_email" autocomplete="none">
                    <div class="text-danger" id="owner_email-span"></div>
                </div>
                <div class="form-group">
                    <input id="owner_phone" type="text" placeholder="Phone" value="{{$ads_owner->owner_phone}}" name="owner_phone" autocomplete="none">
                    <div class="text-danger" id="owner_phone-span"></div>
                </div>
                <input id="second" type="submit" class="fadeIn third" value="{{ __('Submit') }}">
            </form>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script>

    const host = "http://127.0.0.1:8000"
    const state = document.querySelector('#state-input');
    const city = document.querySelector('#city-input');
        state.addEventListener('change',()=>{
        $.ajax({
            type:"GET",
            headers:{
                "Accept":"application/json"
            },
            url:`${host}/territory/city/select/${state.value}`,
            success:(res)=>{
                city.innerHTML = "";
                const data= res.data;
                console.log(res);
                data.map((value)=>{

                    const option = document.createElement("option");
                    option.text = value.city;
                    option.value = value.city;
                    city.appendChild(option);
                });
            }
        })

    });
    </script>
@endsection
