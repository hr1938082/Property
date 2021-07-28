@extends('layouts.admin.master')

@section('title')
Edit Property Images
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}" />
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
@endsection
@section('content')
<div class="row justify-content-center align-items-center m-0">
    <div class="wrapper fadeInDown">
        <div id="formContent" class="pt-3 pb-2" style="margin-top: 120px;">
            <form method="POST" action="{{ route('updateimage') }}" enctype="multipart/form-data">
                @csrf
                <div class="col-md-12">
                    @if (session('status') == "Updated")
                        <div class="alert alert-success">
                            {{session('status')}}
                        </div>
                    @endif
                    <h5>Upload Images</h5>
                    <div class="card shadow-sm">
                        <div class="card-header d-flex justify-content-center">
                            <input type="file" name="images[]" id="inpImg" multiple hidden>
                            <input type="hidden" value="{{$id}}" name="property_id">
                            <input type="button" id="image_btn" value="{{ __('Choose Images') }}">
                        </div>
                        <div class="card-body d-flex flex-wrap justify-content-center" id="imgContainerMulti">
                        </div>
                        <p class="d-none" id="cardBodyPara">File Not Supported</p>
                    </div>
                </div>
                <input type="submit" id="third" value="{{ __('Submit') }}">
            </form>
        </div>
    </div>
    @if ($select->count()>0)
        <div class="col-md-5 border my-5 bg-white shadow-lg">
            @if (session('status') == "Deleted")
                <div class="mt-3 mb-0 text-center alert alert-danger">
                    {{session('status')}}
                </div>
            @endif
            <h5 class="text-center pt-1">Delete Images</h5>
            @foreach ($select as $item)
            <div class="img_div pb-3 text-center" >
                <img src="{{ asset($item->name_dir) }}" class="img-thumbnail" alt="property:{{"$id"}}">
                <form action="{{ route('deleteImage') }}" method="post">
                    @csrf
                    <div class="form-group form-row justify-content-center">
                        <input type="hidden" value="{{$item->id}}" name="id">
                        <button class="btn btn-block btn-danger w-75"><i class="fas fa-trash-alt"></i></button>
                    </div>
                </form>
            </div>
                @endforeach
            </div>
        </div>
    @else
    <div class="col-md-5 border my-5 bg-white shadow-lg">
        @if (session('status') == "Deleted")
            <div class="my-3 alert alert-danger">
                {{session('status')}}
            </div>
        @endif
    </div>
    @endif
</div>
@endsection
@section('js')
<script>
    const inpImg = document.querySelector('#inpImg');
    const image_btn = document.querySelector('#image_btn');
    const cardBody = document.querySelector('.card-body');
    const cardBodyPara = document.querySelector('#cardBodyPara');
    image_btn.addEventListener('click', () => {
        inpImg.click();
    });
    inpImg.addEventListener('change', (e) => {
        const files = inpImg.files;
        cardBody.innerHTML = "";
        for (const fileFill of files) {
            if (fileFill) {
                if ((/\.(gif|jpe?g|tiff?|png|webp|bmp)$/i).test(fileFill.name)) {
                    cardBodyPara.classList.remove('d-block');
                    cardBodyPara.classList.add('d-none');
                    const reader = new FileReader();
                    reader.addEventListener('load', () => {
                        const img = document.createElement('img');
                        img.src = reader.result;
                        cardBody.appendChild(img)
                    }, false);
                    reader.readAsDataURL(fileFill);
                } else {
                    cardBodyPara.classList.remove('d-none');
                    cardBody.classList.add('d-block')
                }
            }
        }
    });
</script>
@endsection
