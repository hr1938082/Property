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
        <div class="col-12 d-flex justify-content-between">
            <h3 class="text-primary d-none d-lg-block" style="color: ">Users</h3>
            <form action="{{ route('manageuser') }}" class="mb-3" method="get" id="usersearch">
                <select name="column" id="">
                    <option value="id">Id</option>
                    <option value="email">Email</option>
                </select>
                <input type="search" class="border-left-0" name="search" placeholder="Search">
            </form>
        </div>
        <table class="table table-bordered ">
            <thead>
                <tr class="text-center">
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Type</th>
                    <th scope="col">Email</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($select as $item)
                <tr class="text-center">
                    <td>{{$item->id}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->user_type_name}}</td>
                    <td>{{$item->email}}</td>
                    <td>
                        <a href="{{ route('edituser', ['id'=>$item->id]) }}" class="btn btn-outline-primary btn-sm"><i class="far fa-eye"></i></a>
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
