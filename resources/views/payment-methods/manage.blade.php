@extends('layouts.admin.master')

@section('title')
Payment Methods
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
@endsection

@section('content')
<div class="row justify-content-center align-items-center m-0" id="register">
    <div class="col-md-8 form px-5 pt-3 active shadow-lg">
        <div class="col-12 d-flex justify-content-between">
            <h3 class="text-primary d-none d-lg-block" style="color: ">Payment Methods</h3>
            @if (session('status') == "Password not matched" ||
                session('status') == "Not Updated" ||
                session('status') == "Not Disabled" ||
                session('status') == "Not Found")
                <h5 class="alert alert-danger text-danger">
                    {{session('status')}}
                </h5>
            @endif
            @if (session('status') == "Update" ||
                session('status') == "Disabled" ||
                session('status') == "Enabled")
            <h5 class="alert alert-success text-success">
                {{session('status')}}
            </h5>
            @endif
        </div>
        <table class="table table-bordered ">
            <thead>
                <tr class="text-center">
                    <th scope="col">S.NO</th>
                    <th scope="col">Name</th>
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
                    <td>@if ($item->status == 1)
                        {{"Enable"}}
                        @else
                        {{"Disable"}}
                    @endif</td>
                    <td class="text-center">
                        @if ($item->name == "Stripe" || $item->name == "stripe" || $item->name == "STRIPE" || $item->name == "Bank" || $item->name == "bank" || $item->name == "BANK")
                        <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal"
                            data-target="#exampleModal">
                            <i class="far fa-eye"></i>
                        </button>
                        @endif
                        <form class="d-inline" action="{{ route('pay-met-soft-del') }}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{$item->id}}">
                            <input type="hidden" name="status" value="
                            @if ($item->status == 1)
                                {{0}}
                            @endif
                            @if ($item->status == 0)
                                {{1}}
                            @endif
                            ">
                            <button type="submit" class="btn btn-sm
                            @if (!($item->name == "Stripe" || $item->name == "stripe" || $item->name == "STRIPE"|| $item->name == "Bank" || $item->name == "bank" || $item->name == "BANK"))
                                btn-block
                            @endif
                            @if ($item->status == 1)
                                {{"btn-danger"}}
                            @endif
                            @if ($item->status == 0)
                                {{"btn-success"}}
                            @endif
                                ">
                                @if ($item->status == 1)
                                    {{"Disable"}}
                                @endif
                                @if ($item->status == 0)
                                    {{"Enable"}}
                            @endif
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('pay-met-auth') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" id="id" name="id">
                        <input type="password" class="form-control" name="pass" placeholder="pass">
                    </div>
                    <input type="submit" class="btn btn-block btn-primary" value="Submit">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script>
        $(document).ready(function(){
            $('.table tbody').on('click','.btn',function(){
                var crow = $(this).closest('tr');
                var col1 = crow.find('td:eq(0)').text();
                $('#id').val(col1);
            });
        });
    </script>
@endsection
