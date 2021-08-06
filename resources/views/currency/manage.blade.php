@extends('layouts.admin.master')

@section('title')
Manage Currency
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
@endsection

@section('content')
<div class="row justify-content-center align-items-center m-0" id="register">
    <div class="col-md-8 form px-5 pt-3 active shadow-lg">
        <div class="col-12 d-flex justify-content-between">
            <h3 class="text-primary d-none d-lg-block" style="color: ">Currency</h3>
            <form action="" class="mb-3" method="get" id="usersearch">
                <input type="search" class="rounded" name="search" placeholder="Search">
            </form>
        </div>
        <table class="table table-bordered ">
            <thead>
                <tr class="text-center">
                    <th scope="col">Id</th>
                    <th scope="col">Currency</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($select as $item)
                <tr class="text-center">
                    <td>{{$item->id}}</td>
                    <td>{{$item->currency}}</td>
                    <td>
                        @isset($item->status)
                            @if ($item->status == 1)
                                {{"Enabled"}}
                            @else
                                {{"Disabled"}}
                            @endif
                        @endisset
                    </td>
                    <td>
                        <a href="{{ route('currencyEdit', ['id'=>$item->id]) }}" class="btn btn-outline-primary btn-sm"><i class="far fa-edit"></i></a>
                        @isset($item->status)
                            @if ($item->status ==1)
                                <a href="{{ route('currencystatUpdate', ['id'=>$item->id]) }}" class="btn btn-outline-danger btn-sm">Disable</a>
                            @else
                                <a href="{{ route('currencystatUpdate', ['id'=>$item->id]) }}" class="btn btn-outline-success btn-sm">Enable</a>
                            @endif
                        @endisset
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
