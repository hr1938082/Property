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
                        {{$select->user_name}}
                    </td>
                </tr>
                <tr class="text-center">
                    <th>Email</th>
                    <td>
                        {{$select->email}}
                    </td>
                </tr>
                <tr class="text-center">
                    <th>Role</th>
                    <td>
                        {{$select->type_name}}
                    </td>
                </tr>
                <tr class="text-center">
                    <th>Last Subscription</th>
                    <td>
                        @if ($select_subs->count()>0)
                            {{$select_subs[0]->subscription}}
                        @endif
                    </td>
                </tr>
                <tr class="text-center">
                    <th>Period</th>
                    <td>
                        @if ($select_subs->count()>0)
                            {{$select_subs[0]->period.' '.$select_subs[0]->type}}
                        @endif
                    </td>
                </tr>
                <tr class="text-center">
                    <th>Expiry Date</th>
                    <td>
                        @if ($select_subs->count()>0)
                            {{$select_subs[0]->expiry_date}}
                        @endif
                    </td>
                </tr>
                <tr class="text-center">
                    <th>Days left to expire</th>
                    <td>
                        @if ($select_subs->count()>0)
                            {{$expiry_diff ?? ''}}
                        @endif
                    </td>
                </tr>
                <tr class="text-center">
                    <th>Status</th>
                    <td>
                        @if ($select_subs->count()>0)
                        @if ($select_subs[0]->status == 1)
                            {{"Enable"}}
                        @endif
                        @if ($select_subs[0]->status == 0)
                            {{"Disable"}}
                        @endif
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
        @if ($expiry_diff ?? false)
            @if ($expiry_diff <= 0)
                @if ($select->type_name == "landlord" || $select->type_name == "Landlord")
                    <a href="{{ route('user-subs-add-view',["id"=>$select->id]) }}" class="btn btn-block mb-3 btn-sm btn-primary">
                        New Subscription
                    </a>
                @endif
            @endif
        @endif
    </div>
</div>
@endsection
