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
            <h3 class="text-primary d-none d-lg-block" style="color: ">Countries</h3>
            @if (session('status') == "Not Found")
            <h5 class="alert alert-danger">{{session('status')}}</h5>
            @endif
            @if (session('status') == "Disabled")

            @endif
            @if (session('status') == "Enabled")
                <h5 class="alert alert-success">{{session('status')}}</h5>
            @endif
        </div>
        <table class="table table-bordered ">
            <thead>
                <tr class="text-center">
                    <th scope="col">S.NO</th>
                    <th scope="col">States</th>
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
                        <td>{{$item->country}}</td>
                        <td>
                            @if ($item->status == 1)
                                {{"Enable"}}
                            @else
                                {{"Disable"}}
                            @endif
                        </td>
                        <td>
                            <a href="update/{{$item->id}}" class="btn btn-sm btn-block
                                @if ($item->status == 1)
                                    {{"btn-danger"}}
                                @else
                                    {{"btn-success"}}
                                @endif
                            ">
                            @if ($item->status == 1)
                                {{"Disable"}}
                            @else
                                {{"Enable"}}
                            @endif
                            </a>
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
    </div>
</div>
@endsection
