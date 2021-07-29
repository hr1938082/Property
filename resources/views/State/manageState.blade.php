@extends('layouts.admin.master')

@section('title')
Manage States
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
@endsection

@section('content')
<div class="row justify-content-center align-items-center m-0" id="register">
    <div class="col-md-8 form px-5 pt-3 active shadow-lg">
        <div class="col-12 d-flex justify-content-between">
            <h3 class="text-primary d-none d-lg-block" style="color: ">States</h3>
        </div>
        <table class="table table-bordered ">
            <thead>
                <tr class="text-center">
                    <th scope="col">Id</th>
                    <th scope="col">States</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($select as $item)
                    <tr class="text-center">
                        <td>{{$item->id}}</td>
                        <td>{{$item->state}}</td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>
@endsection
