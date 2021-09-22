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
            <h3 class="text-primary d-none d-lg-block" style="color: ">Tenants</h3>
            <form action="" class="mb-3" method="get" id="usersearch">
                <select name="ptn" class="border-right-0">
                    <option value="name">Name</option>
                    <option value="property_name">Property</option>
                </select>
                <select name="is_live" class="rounded-0 border-left-0">
                    <option value="">All</option>
                    <option value="1">IN</option>
                    <option value="0">OUT</option>
                </select>
                <input type="search" class="border-left-0" name="pts" placeholder="Search">
            </form>
        </div>
        <table class="table table-bordered ">
            <thead>
                <tr class="text-center">
                    <th scope="col">S.NO</th>
                    <th scope="col">Name</th>
                    <th scope="col">Property</th>
                    <th scope="col">Rent</th>
                    <th scope="col">Status</th>
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
