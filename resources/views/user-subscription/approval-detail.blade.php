@extends('layouts.admin.master')

@section('title')
Approval Detail
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
@endsection
@section('content')
<div class="row justify-content-center align-items-center m-0" id="register">
    <div class="col-md-8 pt-3 form active shadow-lg rounded">
        @if(session('status'))
            <h5 class="alert alert-danger text-danger w-100 text-center">{{session('status')}}</h5>
        @endif
        <h3 class="text-capitalize text-primary">
            {{"Approval Details"}}
        </h3>
        <table class="table table-bordered">
            <tbody>
                <tr class="text-center">
                    <th>Name</th>
                    <td class="text-capitalize">
                        {{$select->name}}
                    </td>
                </tr>
                <tr class="text-center">
                    <th>Email</th>
                    <td>
                        {{$select->email}}
                    </td>
                </tr>
                <tr class="text-center">
                    <th>Subscription</th>
                    <td>
                        {{$select->subs_name}}
                    </td>
                </tr>
                <tr class="text-center">
                    <th>Period</th>
                    <td>
                        {{"$select->period $select->type"}}
                    </td>
                </tr>
                <tr class="text-center">
                    <th>Amount</th>
                    <td>
                        {{$select->amount}}
                    </td>
                </tr>
                <tr class="text-center">
                    <th>Bank_info</th>
                    <td>
                        {{$select->bank_info}}
                    </td>
                </tr>
                <tr class="text-center">
                    <th>Status</th>
                    <td>
                        @if ($select->status == 1)
                            {{"Approved"}}
                        @endif
                        @if ($select->status == 0)
                            {{"Pending"}}
                        @endif
                    </td>
                </tr>
                <tr class="text-center">
                    <th>Image</th>
                    <td>
                        <form method="POST" action="{{ route('user-subs-approval-image-view') }}">
                            @csrf
                            <input type="hidden" name="path" value="{{$select->image}}">
                            <button class="btn btn-sm btn-primary">
                                <i class="far fa-eye"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
        @if ($select->status == 0)
            <form action="{{ route('user-subs-approve') }}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{$select->id}}">
                <button class="btn mb-2 btn-block btn-sm btn-primary">
                    Approve
                </button>
            </form>
        @endif
    </div>
</div>
@endsection