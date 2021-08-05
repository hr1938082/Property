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
            <form action="{{ route('updateaddress') }}" method="post">
                <div class="form-group">
                    <div class="form-inline justify-content-center">
                        @csrf
                            <input type="hidden" name="id" value="{{$id}}">
                            <select class="fadeIn first
                                @error('state')
                                    {{"border border-danger"}}
                                @enderror
                            " name="state" id="state-input" style="width: 185px">
                                <option selected disabled>State</option>
                                @foreach ($state as $item)
                                    @if ($item->state == $property_address->state)
                                        <option selected value="{{$item->state}}">{{$item->state}}</option>
                                    @else
                                        <option value="{{$item->state}}">{{$item->state}}</option>
                                    @endif
                                @endforeach
                            </select>
                            <select class="fadeIn first
                            @error('city')
                                {{"border border-danger"}}
                            @enderror
                            " name="city" id="city-input" style="width: 185px">
                                <option selected disabled>City</option>
                                @foreach ($city as $item)
                                    @if ($item->city == $property_address->city)

                                        <option selected value="{{$item->city}}">{{$item->city}}</option>
                                    @else
                                        <option value="{{$item->city}}">{{$item->city}}</option>
                                    @endif
                                @endforeach
                            </select>
                    </div>
                    <div class="text-danger">
                        @error('state')
                            {{"State is required"}}
                        @enderror
                        @error('city')
                            {{"City is required"}}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <input type="text" class="fadeIn second
                    @error('street')
                        {{"border border-danger"}}
                    @enderror
                    " placeholder="Street" value="{{$property_address->street}}" autofocus name="street" autocomplete="off">
                    <div class="text-danger">
                        @error('street')
                            {{"Street is required"}}
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                        <input id="zipcode" class="fadeIn second
                        @error('zip_code')
                            {{"border border-danger"}}
                        @enderror
                        " type="text" placeholder="Zip Code" value="{{$property_address->zip_code}}" name="zip_code">
                        <div class="text-danger">
                            @error('zip_code')
                                {{"Zip Code is required"}}
                            @enderror
                        </div>
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
