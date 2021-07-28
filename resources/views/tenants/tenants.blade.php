@extends('layouts.admin.master')

@section('title')
Manage User
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
@endsection

@section('content')
<div class="row justify-content-center align-items-center m-0" id="register">
    <div class="col-md-8 form px-5 pt-3 active shadow-lg">
        <div class="row justify-content-center">
            @if(session('status') == "Disabled" || session('status') == "Enabled")
                <h5 class="alert alert-success text-success w-100 text-center">{{session('status')}}</h5>
            @endif
            @if(session('status') == "error" || session('status') == "not found")
                <h5 class="alert alert-danger text-danger w-100 text-center">{{session('status')}}</h5>
            @endif

        </div>
        <div class="col-12 d-flex justify-content-between">
            <h3 class="text-primary d-none d-lg-block" style="color: ">Subscription</h3>
        </div>
        <table class="table table-bordered ">
            <thead>
                <tr class="text-center">
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Property</th>
                    <th scope="col">Rent</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($select as $item)
                <tr class="text-center">
                    <td>{{$item->id}}</td>
                    <td>{{$item->tenants}}</td>
                    <td class="text-capitalize">{{$item->property}}</td>
                    <td>{{$item->rent}}</td>
                    @if ($item->is_live == 1)
                        <td class="text-capitalize text-success">
                            {{"IN"}}
                        </td>
                    @else
                    <td class="text-capitalize text-danger">
                        {{"OUT"}}
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>

        </table>
        <div class="clearfix">
            <div class="float-right">
                @if ($select instanceof \Illuminate\Pagination\AbstractPaginator)
                {{$select->links()}}
                @endif
            </div>
        </div>
        {{-- @endisset --}}
    </div>
</div>
@endsection
