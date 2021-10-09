@extends('layouts.admin.master')

@section('title')
Edit User Details
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
@endsection
@section('content')
<div class="row justify-content-center align-items-center m-0" id="register">
    <div class="col-md-8 form active shadow-lg rounded">
        <div class="row my-2">
            <div class="profile_image col-5 d-flex align-items-center">
                <div class="img">
                    <img src="{{ asset($check->image) }}" alt="">
                    <button type="button" data-target="#profile_preview" data-toggle="modal"><i
                            class="fas fa-edit"></i></button>
                </div>
                <div class="ml-2">
                    <h4 class="text-primary mb-0 font-weight-lighter">{{$check->name}}</h4>
                    <p class="text-secondary mb-0">{{$name}}</p>
                </div>
            </div>
            <div class="col-7 d-flex align-items-center">
                <h5 class="
                @isset($email)
                    @if($email==0) {{"alert alert-danger text-danger"}} @endif
                    @if($email==1) {{"alert alert-success text-success"}} @endif
                @endisset
                @if ($errors->any())
                {{"alert alert-danger text-danger"}}
                @endif
                @isset($password)
                @if ($password == 1)
                    {{"alert alert-success text-success"}}
                @endif @endisset" id="passerror">
                    @isset($email)
                    @if($email == 0)
                    {{"Email Not Available"}}
                    @endif
                    @if($email == 1)
                    {{"Email Updated"}}
                    @endif
                    @endisset
                    @isset($password)
                    @if($password == 1)
                    {{"Password Updated"}}
                    @endif
                    @endisset
                    @error('password')
                    {{$message}}
                    @enderror
                    @error('email')
                    {{$message}}
                    @enderror
                    @error('profile')
                    {{$message}}
                    @enderror
                </h5>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="profile_preview" data-backdrop="static" data-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-primary" id="verifylabel">Upload Profile</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="preview">
                                <div class="image">
                                    <img src="" alt="" />
                                </div>
                                <div class="content">
                                    <div class="icon">
                                        <i class="fas fa-cloud-upload-alt">
                                        </i>
                                    </div>
                                    <div class="text">
                                        No file chosen
                                    </div>
                                </div>
                                <div id="cancel-btn">
                                    <i class="fas fa-times"></i>
                                </div>
                                <div class="file-name text-center">
                                    File name here
                                </div>
                            </div>
                            <form action="{{ route('Adminupdateimage') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" value="{{$id}}" name="id">
                                <input type="file" name="profile" id="profile" hidden>
                                <button type="button" onclick="profileBtnActive()" id="custom-btn">Choose a
                                    file</button>
                                <input type="submit" value="UPLOAD" class="upload-btn">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="">
            <table class="table table-bordered">
                <tbody>
                    <tr class="text-center">
                        <th>Name</th>
                        <td>
                            <span class="d-block name">{{$check->name}}</span>
                            <span class="d-none nameForm">
                                <form action="{{ route('updatename') }}" method="post">
                                    @csrf
                                    <input type="hidden" value="{{$id}}" name="id" required>
                                    <input type="text" class="text-center" required name="name" id="name"
                                        value="{{$check->name}}" placeholder="Name">
                            </span>
                        </td>

                        <td>
                            <span class="d-none nameForm">
                                <input class="btn btn-primary btn-sm" type="submit" value="Submit">
                                </form>
                            </span>
                            <span class="d-block name">
                                <button id="nameBtn" class="btn btn-outline-warning"><i
                                        class="fas fa-edit"></i></button>
                            </span>
                        </td>
                    </tr>
                    <tr class="text-center">
                        <th>User Type</th>
                        <td>
                            <span class="d-block usertype">{{$name}}</span>
                            <span class="d-none usertypeForm">
                                <form action="{{ route('updateusertype') }}" method="post">
                                    @csrf
                                    <input type="hidden" value="{{$id}}" name="id">
                                    <select name="user_type_id" id="user_type_id">
                                        @foreach ($usertype as $item)
                                        @php
                                        if($name == $item->name)
                                        {
                                        $select = "selected";
                                        }
                                        else {
                                        $select = "";
                                        }
                                        @endphp
                                        <option {{$select}} value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                            </span>
                        </td>

                        <td>
                            <span class="d-none usertypeForm">
                                <input class="btn btn-primary btn-sm" type="submit" value="Submit">
                                </form>
                            </span>
                            <span class="d-block usertype">
                                <button id="usertypeBtn" class="btn btn-outline-warning"><i
                                        class="fas fa-edit"></i></button>
                            </span>
                        </td>
                    </tr>
                    <tr class="text-center">
                        <th>Email</th>
                        <td>
                            <span class="d-block email">
                                {{$check->email}}

                            </span>
                            <span class="d-none emailForm">
                                <form action="{{ route('updateemail') }}" method="post">
                                    @csrf
                                    <input type="hidden" value="{{$id}}" name="id">
                                    <input type="text" class="text-center" required name="email" id="email"
                                        value="{{$check->email}}" placeholder="Email">
                            </span>
                        </td>
                        <td>
                            <span class="d-none emailForm">
                                <input class="btn btn-primary btn-sm" type="submit" value="Submit">
                                </form>
                            </span>
                            <span class="d-block email">
                                <button id="emailBtn" class="btn btn-outline-warning"><i
                                        class="fas fa-edit"></i></button>
                            </span>
                        </td>
                    </tr>
                    <tr class="text-center">
                        <th>Password</th>
                        <td>
                            <span class="d-block pass">
                                ***********
                                <input type="hidden" value="@if($password==" Password Correct"){{$password}}@endif"
                                    id="pass">
                            </span>
                            <span class="d-none passForm">
                                <form action="{{ route('updatepass') }}" method="post">
                                    @csrf
                                    <input type="hidden" value="{{$id}}" name="id">
                                    <input type="password" class="text-center" required name="password" id="email"
                                        placeholder="Password">
                            </span>
                        </td>
                        <td>
                            <span class="d-none passForm">
                                <input class="btn btn-primary btn-sm" type="submit" value="Submit">
                                </form>
                            </span>
                            <span class="d-block pass">
                                <button data-target="#verify" data-toggle="modal" class="btn btn-outline-warning">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </span>
                        </td>
                    </tr>
                    <tr class="text-center">
                        <th>Mobile</th>
                        <td>
                            <span class="d-block mobile">
                                {{$check->mobile}}

                            </span>
                            <span class="d-none mobileForm">
                                <form action="{{ route('updatemob') }}" method="post">
                                    @csrf
                                    <input type="hidden" value="{{$id}}" name="id">
                                    <input type="text" class="text-center" required name="mobile" id="mobile"
                                        value="{{$check->mobile}}" placeholder="mobile">
                            </span>
                        </td>
                        <td>
                            <span class="d-none mobileForm">
                                <input class="btn btn-primary btn-sm" type="submit" value="Submit">
                                </form>
                            </span>
                            <span class="d-block mobile">
                                <button id="mobileBtn" class="btn btn-outline-warning"><i
                                        class="fas fa-edit"></i></button>
                            </span>
                        </td>
                    </tr>
                    <tr class="text-center">
                        <th>Address</th>
                        <td>
                            <span class="d-block address">
                                {{$check->address}}

                            </span>
                            <span class="d-none addressForm">
                                <form action="{{ route('updateadd') }}" method="post">
                                    @csrf
                                    <input type="hidden" value="{{$id}}" name="id">
                                    <input type="text" class="text-center" required name="address" id="address"
                                        value="{{$check->address}}" placeholder="address">
                            </span>
                        </td>
                        <td>
                            <span class="d-none addressForm">
                                <input class="btn btn-primary btn-sm" type="submit" value="Submit">
                                </form>
                            </span>
                            <span class="d-block address">
                                <button id="addressBtn" class="btn btn-outline-warning"><i
                                        class="fas fa-edit"></i></button>
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="verify" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-primary" id="verifylabel">Verify Its You</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body d-flex justify-content-center">
                        <form id="passSub" method="post">
                            <div class="form-group form-row">
                                @csrf
                                <input type="hidden" value="{{Auth::user()->id}}" name="id">
                                <label for="pass">Password</label>
                                <input type="password" class="mx-1" name="password" id="password">
                                <input type="submit" value="Verify" class="btn btn-primary btn-sm">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    const preview = document.querySelector('.preview');
    const filename = document.querySelector('.file-name');
    const profile = document.querySelector('#profile');
    const custom_btn = document.querySelector('#custom-btn');
    const img = document.querySelector('.image img');
    const cancel_btn = document.querySelector('#cancel-btn');
    const upload_btn = document.querySelector('.upload-btn');
    const regExp = /[0-9a-zA-Z\^\&\'\@\{\}\[\]\,\$\=\!\-\#\(\)\.\%\+\~\_]+$/;

    function profileBtnActive() {
        profile.click();
    }
    profile.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function () {
                const result = reader.result;
                img.src = result;
                preview.classList.add('active');
                upload_btn.classList.add('active');
            }
            cancel_btn.addEventListener("click", () => {
                img.src = "";
                preview.classList.remove('active');
                upload_btn.classList.remove('active');
            });
            reader.readAsDataURL(file);
            if (this.value) {
                let storeValue = this.value.match(regExp);
                filename.textContent = storeValue;
            }
        }
    })
    $(document).ready(function () {
        $('#nameBtn').click(function () {
            $('.name').removeClass('d-block');
            $('.name').addClass('d-none');
            $('.nameForm').removeClass('d-none');
            $('.nameForm').addClass('d-block');
        });
        $('#usertypeBtn').click(function () {
            $('.usertype').removeClass('d-block');
            $('.usertype').addClass('d-none');
            $('.usertypeForm').removeClass('d-none');
            $('.usertypeForm').addClass('d-block');
        });
        $('#emailBtn').click(function () {
            $('.email').removeClass('d-block');
            $('.email').addClass('d-none');
            $('.emailForm').removeClass('d-none');
            $('.emailForm').addClass('d-block');
        });
        $('#mobileBtn').click(function () {
            $('.mobile').removeClass('d-block');
            $('.mobile').addClass('d-none');
            $('.mobileForm').removeClass('d-none');
            $('.mobileForm').addClass('d-block');
        });
        $('#addressBtn').click(function () {
            $('.address').removeClass('d-block');
            $('.address').addClass('d-none');
            $('.addressForm').removeClass('d-none');
            $('.addressForm').addClass('d-block');
        });
        $('#passSub').submit(function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: 'check/password',
                data: $(this).serialize(),
                success: function (response) {
                    if (response == "Password Correct") {
                        $('#passerror').empty().removeClass(
                            'alert alert-danger text-danger'
                            );
                        $('.pass').removeClass('d-block');
                        $('.pass').addClass('d-none');
                        $('.passForm').removeClass('d-none');
                        $('.passForm').addClass('d-block');
                        $('#verify').modal('hide');
                    } else {
                        $('#passerror').empty();
                        $('#passerror').append(response).addClass(
                            'alert alert-danger text-danger');
                        $('#verify').modal('hide');
                    }
                }
            })
        });
    });

</script>
@endsection
