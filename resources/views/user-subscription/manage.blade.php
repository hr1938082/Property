@extends('layouts.admin.master')

@section('title')
Manage User Subscription
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
@endsection

@section('content')
<div class="row justify-content-center align-items-center m-0" id="register">
    <div class="col-md-8 form pt-3 active shadow-lg">
        <div class="row justify-content-center">
            @if(session('status') == "Disabled" || session('status') == "Enabled")
            <h5 class="alert alert-success text-success w-100 text-center">{{session('status')}}</h5>
            @endif
            @if(session('status') == "error" ||
            session('status') == "not found" ||
            session('status') == "Not Found" ||
            session('status') == "Can not updated")
            <h5 class="alert alert-danger text-danger w-100 text-center">{{session('status')}}</h5>
            @endif

        </div>
        <div class="col-12 d-flex justify-content-between">
            <h3 class="text-primary d-none d-lg-block" style="color: ">Subscription</h3>
            <form action="{{ route('user-subs-view') }}" class="mb-3" method="get" id="usersearch">
                <select name="column" id="">
                    <option value="users.name">Name</option>
                    <option value="users.email">Email</option>
                    <option value="subscriptions.name">Subscription</option>
                </select>
                <input type="search" class="border-left-0" name="search" placeholder="Search">
            </form>
        </div>
        <table class="table table-bordered ">
            <thead>
                <tr class="text-center">
                    <th scope="col">S.NO</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Subscription</th>
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
                    <td>{{$item->email}}</td>
                    <td>{{$item->subscription}}</td>
                    <td>
                        @php
                        if (isset($item->status)) {
                            if($item->status == 1)
                            {
                                echo "Enable";
                            }
                            else
                            {
                                echo "Disable";
                            }
                        }
                        else {
                            echo "";
                        }
                        @endphp
                    </td>
                    <td>
                        @foreach ($expiryDate as $val)
                        @if ($item->id == $val["id"])
                        <form action="{{ route('user-subs-fetch-detail-view') }}" class="d-inline" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{$item->user_id}}" />
                            <button type="submit" class="btn btn-sm
                                @if (!($val["expiry_date"] >0))
                                    btn-block
                                @endif
                            btn-outline-primary">
                                <i class="far fa-eye"></i>
                            </button>
                        </form>
                        @if ($val["expiry_date"] >0)
                        <form action="{{ route('user-subs-stat-view') }}" class="d-inline" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{$item->id}}" />
                            <input type="hidden" name="val" value="
                                            @php
                                                if($item->status == 1)
                                                {
                                                    echo 0;
                                                }
                                                else
                                                {
                                                    echo 1;
                                                }
                                            @endphp">
                            <button class="btn btn-sm mb-1
                                        @php
                                            if($item->status == 1)
                                            {
                                                echo " btn-outline-danger"; } else { echo "btn-outline-success" ; }
                                @endphp">
                                @php
                                if (isset($item->status)) {
                                if($item->status == 1)
                                {
                                echo "Disable";
                                }
                                else
                                {
                                echo "Enable";
                                }
                                }
                                else {
                                echo "";
                                }
                                @endphp
                            </button>
                        </form>
                        @endif
                        @endif
                        @endforeach

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
