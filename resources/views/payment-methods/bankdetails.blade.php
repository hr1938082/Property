@extends('layouts.admin.master')

@section('title')
{{$select->name." Details"}}
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
@endsection
@section('content')
<div class="row justify-content-center align-items-center m-0" id="register">
    <div class="col-md-8 pt-3 form active shadow-lg rounded">
        <h3 class="text-capitalize text-primary">
            {{$select->name." Details"}}
        </h3>
        <table class="table table-bordered">
            <tbody>
                <tr class="text-center">
                    <th>Name</th>
                    <td class="text-capitalize">
                        {{$select->bank_name}}
                    </td>
                </tr>
                <tr class="text-center">
                    <th>Account Name</th>
                    <td>
                        {{$select->account_name}}
                    </td>
                </tr>
                <tr class="text-center">
                    <th>Account Numbre</th>
                    <td>
                        {{$select->account_number}}
                    </td>
                </tr>
                <tr class="text-center">
                    <th>BSB</th>
                    <td>
                        {{$select->bsb}}
                    </td>
                </tr>
                <tr class="text-center">
                    <th>Country</th>
                    <td>
                        {{$select->country}}
                    </td>
                </tr>
                <tr class="text-center">
                    <th>Account Currency</th>
                    <td>
                        {{$select->account_currency}}
                    </td>
                </tr>
            </tbody>
        </table>
        <button class="btn-primary btn-block btn-sm mb-3" data-toggle="modal" data-target="#exampleModal">
            Edit
        </button>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Bank Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('Bankdetails.update') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" value="{{$select->id}}" name="id">
                        <input type="text" class="form-control" value="{{$select->bank_name}}" placeholder="Name"
                            name="bank_name">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" value="{{$select->account_name}}"
                            placeholder="Account Name" name="account_name">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" value="{{$select->account_number}}"
                            placeholder="Account Number" name="account_number">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" value="{{$select->bsb}}" placeholder="BSB" name="bsb">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" value="{{$select->country}}" placeholder="Country"
                            name="country">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" value="{{$select->account_currency}}"
                            placeholder="Account Currency" name="account_currency">
                    </div>
                    <input type="submit" class="btn btn-primary btn-block btn-sm" value="Submit">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
