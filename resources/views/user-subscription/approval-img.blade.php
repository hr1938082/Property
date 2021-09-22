@extends('layouts.admin.master')

@section('title')
Approval Detail
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
@endsection
@section('content')
<div class="row justify-content-center align-items-center" style="height: 80vh;margin-top: 10vh !important">
    <div class="rounded-lg" style="overflow: hidden; height: 100%; width: 450px">
        <img src="{{ asset($path) }}" style="height: 100%" alt="">
    </div>
</div>
@endsection
