@extends('layouts.admin.master')

@section('title')
Manage Properties
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
@endsection

@section('content')
<div class="row justify-content-center align-items-center m-0" id="register">
    <div class="col-md-8 form px-5 pt-3 active shadow-lg">
        <div class="row justify-content-center">
            @if (session('status') === 'link is required')
                <h3 class="alert alert-danger">{{session('status')}}</h3>
            @endif
            @if (session('status') === "Updated")
                <h3 class="alert alert-success">{{session('status')}}</h3>
            @endif
        </div>
        <div class="col-12 d-flex justify-content-between">
            <h3 class="text-primary d-none d-lg-block" style="color: ">Properties</h3>
        </div>
        <table class="table table-bordered ">
            <thead>
                <tr class="text-center">
                    <th scope="col">S.NO</th>
                    <th scope="col">Name</th>
                    <th scope="col">Links</th>
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
                @foreach ($social as $item)
                @php
                    $sno++;
                @endphp
                <tr class="text-center">
                    <td>{{$sno}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->link}}</td>
                    <td>
                        <!-- Button trigger modal -->
                        <button type="button" onclick="getid({{$item->id}})" class="btn btn-outline-warning btn-sm" data-toggle="modal" data-target="#exampleModal">
                            <i class="far fa-edit"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
        </div>
    </div>
</div>

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Update</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('SocialManage.update') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="link">Link</label>
                    <input type="hidden" name="id" id="hiddenid">
                    <input type="text" class="form-control" name="link" id="link" placeholder="Link">
                </div>
                <button type="submit" class="btn btn-primary btn-block btn-sm">Submit</button>
            </form>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('js')
  <script>
      const getid = (id,link) => {
        const hiddenid = document.querySelector('#hiddenid');
        hiddenid.value = id;
      }
  </script>
@endsection
