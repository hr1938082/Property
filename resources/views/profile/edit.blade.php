@extends('layouts.admin.master')
@section('title')
Edit Profile
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
<link rel="stylesheet" href="{{ asset('css/auth.css') }}" />
@endsection
@section('content')
<div class="wrapper fadeInDown">
    <div id="formContent" class="pt-3 pb-2" style="margin-top: 120px;">
        @if (session('status') == "profile-information-updated")
                <div class="alert alert-success m-0" role="alert">
                    {{ "Profile Updated" }}
                </div>
            @endif
            @if (session('status') == "email-not-available")
                <div class="alert alert-danger m-0" role="alert">
                    {{ "Email Not Available" }}
                </div>
            @endif
        <div class="fadeIn first pt-2">
            <div class="profile_image col-12 d-flex justify-content-center">
                <div class="img">
                    <img src="{{ asset(Auth::user()->image) }}" alt="">
                    <button type="button" data-target="#profile_preview" data-toggle="modal"><i
                            class="fas fa-edit"></i></button>
                </div>
            </div>
        </div>
        <!-- Login Form -->
        <form method="POST"  action="{{ route('user-profile-information.update') }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <input id="name" type="text" class="fadeIn second @error('name') is-invalid @enderror"
                    placeholder="Name" name="name" value="{{ Auth::user()->name }}" required autocomplete="name"
                    autofocus>

                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <input id="email" type="email" class="fadeIn second @error('email') is-invalid @enderror" name="email"
                    placeholder="Email" value="{{ Auth::user()->email }}" required autocomplete="email">
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <input id="mobile" type="text" class="fadeIn third" name="mobile" required autocomplete="Mobile"
                    value="{{Auth::user()->mobile}}" placeholder="Mobile">
            </div>
            <div class="form-group">
                <input id="address" type="text" class="fadeIn third" name="address" required autocomplete="Address"
                    value="{{Auth::user()->address}}" placeholder="Address">
            </div>
            <input type="submit" class="fadeIn fourth mb-4" value="{{ __('Update') }}">
    </div>
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
                    @csrf
                    <input type="hidden" value="{{Auth::user()->id}}" name="id">
                    <input type="file" name="profile" id="profile" hidden>
                    <button type="button" onclick="profileBtnActive()" id="custom-btn">Choose a
                        file</button>
                    <button type="submit" class="upload-btn">UPLOAD</button>
                </form>
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
</script>
@endsection
