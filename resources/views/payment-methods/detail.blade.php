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
                        {{$select->name}}
                    </td>
                </tr>
                <tr class="text-center">
                    <th>Key</th>
                    <td>
                        {{$select->key_id}}
                    </td>
                </tr>
                <tr class="text-center">
                    <th>Key Secret</th>
                    <td>
                        {{$select->key_secret}}
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
                <h5 class="modal-title" id="exampleModalLabel">Update Stripe Keys</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('pay-met-update') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" value="{{$select->id}}" name="id">
                        <input type="text" class="form-control" placeholder="Key" name="key_id">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Key Secret" name="key_secret">
                    </div>
                    <input type="submit" class="btn btn-primary btn-block btn-sm" value="Submit">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
