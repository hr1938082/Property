@extends('layouts.admin.master')

@section('title')
Manage City
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
@endsection

@section('content')
<div class="row justify-content-center align-items-center m-0" id="register">
    <div class="col-md-8 form px-5 pt-3 active shadow-lg">
        <div class="col-12 d-flex justify-content-between">
            <h3 class="text-primary d-none d-lg-block" style="color: ">City</h3>
            @if (session('status') == "Not Found")
            <h5 class="alert alert-danger">{{session('status')}}</h5>
            @endif
            @if (session('status') == "Deleted")
            <h5 class="alert alert-success">{{session('status')}}</h5>
            @endif
        </div>
        <table class="table table-bordered ">
            <thead>
                <tr class="text-center">
                    <th scope="col">Id</th>
                    <th scope="col">Cities</th>
                    <th scope="col">States</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($select as $item)
                    <tr class="text-center">
                        <td>{{$item->id}}</td>
                        <td>{{$item->city}}</td>
                        <td>{{$item->state}}</td>
                        <td>
                            <a href="delete/{{$item->id}}" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i></a>
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
