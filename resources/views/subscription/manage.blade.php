@extends('layouts.admin.master')

@section('title')
Manage Subscription
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
                    <th scope="col">S.NO</th>
                    <th scope="col">Name</th>
                    <th scope="col">Type</th>
                    <th scope="col">Period</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    if (isset($_GET['page'])) {
                        if ($_GET['page'] != 1) {
                            $sno= ($_GET['page']*6)-6;
                        }
                        else {
                            $sno = 0;
                        }
                    }
                    else {
                        $sno = 0;
                    }
                @endphp
                @foreach ($select as $item)
                @php
                    $sno++;
                @endphp
                <tr class="text-center">
                    <td>{{$sno}}</td>
                    <td>{{$item->name}}</td>
                    <td class="text-capitalize">{{$item->type}}</td>
                    <td>{{$item->period}}</td>
                    <td>{{$item->amount}}</td>
                    <td class="text-capitalize">@if ($item->status == 1)
                        {{"Enable"}}
                        @else
                        {{"Disable"}}
                    @endif</td>
                    <td>
                        <a href="{{ route('subsEdit', ['id'=>$item->id]) }}" class="btn btn-sm btn-outline-primary"><i class="far fa-edit"></i></a>
                        <form action="{{ route('subs-stat-change') }}" method="post" class="d-inline">
                            @csrf
                            <input type="hidden" name="id" value="{{$item->id}}"/>
                            <input type="hidden" name="val" value="
                            @if ($item->status == 1)
                                {{0}}
                            @endif
                            @if($item->status == 0)
                                {{1}}
                            @endif">
                            <button class="btn btn-sm
                            @if ($item->status == 1)
                                {{"btn-outline-danger"}}
                            @endif
                            @if ($item->status == 0)
                                {{"btn-outline-success"}}
                            @endif
                            ">
                            @if ($item->status == 1)
                                {{"Disable"}}
                            @endif
                            @if($item->status == 0)
                                {{"Enable"}}
                            @endif
                            </button>
                        </form>
                    </td>
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
