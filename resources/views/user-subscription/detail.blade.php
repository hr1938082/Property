@extends('layouts.admin.master')

@section('title')
Subs Detail
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
@endsection
@section('content')
<div class="row justify-content-center align-items-center m-0" id="register">
    <div class="col-md-8 pt-3 form active shadow-lg rounded">
        <h3 class="text-capitalize text-primary">
            {{"Subscription Details"}}
        </h3>
        <table class="table table-bordered">
            <tbody>
                <tr class="text-center">
                    <th>Name</th>
                    <td class="text-capitalize">
                        {{$select->username}}
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
                        {{$select->subscription}}
                    </td>
                </tr>
                <tr class="text-center">
                    <th>Period</th>
                    <td>
                        {{"$select->period $select->type"}}
                    </td>
                </tr>
                <tr class="text-center">
                    <th>Gateway</th>
                    <td>
                        {{$select->name}}
                    </td>
                </tr>
                <tr class="text-center">
                    <th>Gateway type</th>
                    <td>
                        {{$select->gate_type}}
                    </td>
                </tr>
                <tr class="text-center">
                    <th>Amount</th>
                    <td>
                        {{$select->amount}}
                    </td>
                </tr>
                <tr class="text-center">
                    <th>Status</th>
                    <td>
                        @if ($select->status == 1)
                            {{"Enable"}}
                        @endif
                        @if ($select->status == 0)
                            {{"Disable"}}
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection