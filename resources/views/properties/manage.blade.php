@extends('layouts.admin.master')

@section('title')
Manage Properties
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
@endsection

@section('content')
<div class="row justify-content-center align-items-center m-0" id="register">
    <div class="col-md-8 form px-5 pt-3 active shadow-lg">
        <div class="row justify-content-center">
            @if(session('status') == "Enabled")
                <h5 class="alert alert-success text-success w-100 text-center">{{session('status')}}</h5>
            @endif
            @if(session('status') == "Disabled")
                <h5 class="alert alert-danger text-danger w-100 text-center">{{session('status')}}</h5>
            @endif
        </div>
        <div class="col-12 d-flex justify-content-between">
            <h3 class="text-primary d-none d-lg-block" style="color: ">Properties</h3>
            @isset($select)
                <form action="{{ route('manage-properties') }}" class="mb-3" method="get" id="usersearch">
                    <select name="ptn" class="border-right-0">
                        <option value="@php
                            echo base64_encode("property_name")
                        @endphp">Name</option>
                        <option value="@php
                            echo base64_encode("rent_min")
                        @endphp">Min</option>
                        <option value="@php
                            echo base64_encode("rent_max")
                        @endphp">Max</option>
                        <option value="@php
                            echo base64_encode("city")
                        @endphp">City</option>
                        <option value="@php
                            echo base64_encode("state")
                        @endphp">State</option>
                    </select>
                    <select name="status" class="rounded-0 border-left-0">
                        <option value="">All</option>
                        <option value="1">Enable</option>
                        <option value="0">Disable</option>
                    </select>
                    <input type="search" class="border-left-0" name="pts" placeholder="Search">
                </form>
            @endisset
            @isset($status)
                <h5 class="alert alert-danger">{{$status}}</h5>
            @endisset
        </div>
        {{-- @isset($select) --}}
        <table class="table table-bordered ">
            <thead>
                <tr class="text-center">
                    <th scope="col">S.NO</th>
                    <th scope="col">Name</th>
                    <th scope="col">Rent</th>
                    <th scope="col">USD</th>
                    <th scope="col">City</th>
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
                    <td>{{$item->rent}}</td>
                    @php
                        $currencyVal = "not available";
                    @endphp
                    @foreach ($currency as $row)
                        @if ($row->id == $item->currency_id)
                            @php
                                $currencyVal = $row->currency;
                                break;
                            @endphp
                        @endif
                    @endforeach
                    <td>{{$currencyVal}}</td>
                    <td>{{$item->city}}</td>
                    <td>
                        @if ($item->status == 1)
                            Enable
                        @else
                            Disable
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('select-properties', ['id'=>$item->id]) }}" class="btn btn-outline-primary btn-sm"><i class="far fa-eye"></i></a>
                        <form action="{{ route('delete-properties',['id'=>$item->id]) }}" method="get" class="d-inline">
                            @csrf
                            <input type="hidden" name="property_id" value="{{$item->id}}" />
                            @if ($item->status ==1)
                                <button class="btn btn-outline-danger btn-sm">Disable</button>
                            @else
                                <button class="btn btn-outline-success btn-sm">Enable</button>
                            @endif
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
