@extends('layouts.admin.master')

@section('title')
Manage Features
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
@endsection

@section('content')
<div class="row justify-content-center align-items-center m-0" id="register">
    <div class="col-md-8 form pt-3 active shadow-lg">
        <div class="row justify-content-center">
            @if(session('status') == "Deleted")
                <h5 class="alert alert-success text-success w-100 text-center">{{session('status')}}</h5>
            @endif
            @if(session('status') == "Created")
                <h5 class="alert alert-success text-success w-100 text-center">{{session('status')}}</h5>
            @endif
            @if(session('status') == "empty")
                <h5 class="alert alert-danger text-danger w-100 text-center">Can not create empty feature</h5>
            @endif
        </div>
        <div class="col-12 d-flex justify-content-between">
            <h3 class="text-primary d-none d-lg-block" style="color: ">Features</h3>
            <!-- <form class="mb-3" method="get" id="usersearch">
                <input type="search" style="border-radius:5px;width:400px;" name="search" placeholder="Search">
            </form> -->
            <button class="btn btn-primary btn-sm" style="height:30px" data-toggle="modal" data-target="#verify"><i class="fa fa-plus" aria-hidden="true" style="font-size:10px;"></i></button>
        </div>
        <table class="table table-bordered ">
            <thead>
                <tr class="text-center">
                    <th scope="col">S.NO</th>
                    <th scope="col">Name</th>
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
                    <td>{{$item->feature}}</td>
                    <td>
                        <form action="{{ route('feature-delete') }}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{$item->id}}">
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fa fa-trash"></i>
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
    </div>
    <!-- Modal -->
    <div class="modal fade" id="verify" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-primary" id="verifylabel">Add Feature</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body d-flex justify-content-center">
                        <form action="{{route('feature-store')}}" method="post">
                            <div class="form-group">
                                @csrf
                                <label for="feature">Feature</label>
                                <input type="text" class="mx-1" name="feature" id="feature">
                                <input type="submit" value="Submit" class="btn btn-primary btn-sm">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>
@endsection
