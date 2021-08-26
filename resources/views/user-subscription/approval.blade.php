@extends('layouts.admin.master')

@section('title')
Manage Approval
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
@endsection

@section('content')
<div class="row justify-content-center align-items-center m-0" id="register">
    <div class="col-md-8 form pt-3 active shadow-lg">
        <div class="row justify-content-center">

        </div>
        <div class="col-12 d-flex justify-content-between">
            <h3 class="text-primary d-none d-lg-block" style="color: ">Approvals</h3>
            <form action="{{ route('user-subs-approval-view') }}" class="mb-3" method="get" id="usersearch">
                <select name="status" id="">
                    <option value="">All</option>
                    <option value="1">Approved</option>
                    <option value="0">Pending</option>
                </select>
                <input type="search" class="" name="search" placeholder="Search">
            </form>
        </div>
        <table class="table table-bordered ">
            <thead>
                <tr class="text-center">
                    <th scope="col">S.NO</th>
                    <th scope="col">Name</th>
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
                    <td>{{$item->user_name}}</td>
                    <td>{{$item->subs_name}}</td>
                    <td>@if ($item->status == 1)
                        {{"Approved"}}
                        @else
                        {{"Pending"}}
                    @endif</td>
                    <td>
                        <form action="{{ route('user-subs-approval-det-view') }}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{$item->id}}">
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="far fa-eye"></i>
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
