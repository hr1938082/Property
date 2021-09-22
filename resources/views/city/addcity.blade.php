@extends('layouts.admin.master')

@section('title')
Add City
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
                {{ __('Add City') }}
            </div>
            <form action="{{ route('cityInsert') }}" method="post">
                @csrf
                <div class="form-group">
                    <input id="street" type="text" class="fadeIn first" placeholder="City" name="city" autocomplete="none" autofocus>
                    @error('city')
                        <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <select name="state_id" class="border
                    @error('state_id')
                        {{"border-danger"}}
                    @enderror" id="">
                        <option selected disabled>State</option>
                        @foreach ($states as $item)
                            <option value="{{$item->id}}">{{$item->state}}</option>
                        @endforeach
                    </select>

                </div>
                <input type="submit" class="fadeIn fourth" value="{{ __('Submit') }}">
            </form>
        </div>
    </div>
</div>
@endsection
