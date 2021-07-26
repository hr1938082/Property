@extends('layouts.admin.master')

@section('title')
Add Subscription
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}" />
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
@endsection

@section('content')
<div class="wrapper fadeInDown">
    <div id="formContent" class="pt-3 pb-2" style="margin-top: 90px;">
        <div class="fadeIn first my-2">
            @if (session('status'))
                <h5 class="alert alert-danger text-center text-danger">
                    {{session('status')}}
                </h5>
            @endif
            {{ __('Add Subscription') }}
        </div>
        <!-- add subscription -->
        <form method="POST"  action="{{ route('user-subs-add') }}" enctype="multipart/form-data" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="{{$id}}" name="id">
            <div class="form-group">
                <select name="subscription" id="subs_id" class="fadeIn first">
                    <option disabled selected>Subscription</option>
                    @foreach ($select as $item)
                        <option class="text-capitalize" value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                </select>
                @error('subscription')
                    <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group">
                <select name="method" id="pay_method" class="d-none">
                    <option disabled selected>Payment Method</option>
                    @foreach ($select_pay as $item)
                        <option class="text-capitalize" value="{{$item->name}}">{{$item->name}}</option>
                    @endforeach
                </select>
                @error('method')
                    <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
            <div id="card" class="d-none">
                <div class="form-group">
                    <input type="text" class="form-control" name="card_no" placeholder="Card Number">
                    @error('method')
                        <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="form-row justify-content-between" style="padding: 0 35px 0 35px !important">
                    <div class="form-group">
                        <select name="exp_month" class="form-control">
                            <option disabled selected>EXP Month</option>
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="exp_year" class="form-control">
                            <option disabled selected>EXP Year</option>
                            @for ($y = $current_year; $y < ($current_year+5); $y++)
                                <option value="{{$y}}">{{$y}}</option>
                            @endfor
                        </select>
                    </div>
                    <input type="text" class="w-25 form-control text-left p-3" name="cvv" placeholder="CVV">
                </div>
                <div class="form-group">
                    <input type="text" id="card_amount" class="form-control" name="amount" placeholder="Amount" disabled>
                </div>
            </div>
            <div id="bank" class="d-none">
                <div class="form-row justify-content-between px-5 mb-2">
                    <input type="text" id="bankAmount" class="w-50" placeholder="Amount" disabled name="amount">
                    <input id="file" type="file" name="image" hidden>
                    <button id="filepicker" type="button" class="btn btn-sm btn-outline-primary">Choose Image</button>
                </div>
                <div class="form-group">
                    <textarea placeholder="Bank INFO..." class="shadow-none" name="bankinfo" id="" rows="2"></textarea>
                </div>
            </div>
            <div id="cash" class="d-none">
                <div class="form-group">
                    <input type="text" id="cash_amount" class="form-control" name="amount" placeholder="Amount" disabled>
                </div>
            </div>
            <input type="submit" class="fadeIn fourth mb-4" value="{{ __('Submit') }}">
    </div>
</div>
@endsection
@section('js')
    <script>
        const subs = document.querySelector('#subs_id');
        const payMethod = document.querySelector('#pay_method');
        const card = document.querySelector('#card');
        const bank = document.querySelector('#bank');
        const file = document.querySelector('#file');
        const filepicker = document.querySelector('#filepicker');
        const cash =document.querySelector('#cash');
        const bankAmount = document.querySelector('#bankAmount');
        const cardAmount = document.querySelector('#card_amount');
        const cashAmount = document.querySelector('#cash_amount');
        subs.addEventListener('change',()=>{
            const subVal = subs.options[subs.selectedIndex].text;
            if(subVal != "trail" && subVal != "Trail" && subVal != "TRAIL")
            {
                payMethod.classList.remove('d-none');
            }
            else
            {
                if(!payMethod.classList.contains('d-none'))
                {
                    payMethod.classList.add('d-none');
                }
                if(!card.classList.contains('d-none'))
                {
                    cardAmount.disabled = true;
                    card.classList.add('d-none');
                }
                if(!bank.classList.contains('d-none'))
                {
                    bank.classList.add('d-none');
                }
                if(!cash.classList.contains('d-none'))
                {
                    cashAmount.disabled = true;
                    cash.classList.add('d-none')
                }
            }
            if(!payMethod.classList.contains('d-none'))
            {
                payMethod.addEventListener('change',()=>{
                    const payMethodVal = payMethod.options[payMethod.selectedIndex].text;
                    if(payMethodVal == "stripe" || payMethodVal == "Stripe" || payMethodVal == "Stripe")
                    {
                        cardAmount.disabled = false;
                        card.classList.remove('d-none');
                    }
                    else
                    {
                        if(!card.classList.contains('d-none'))
                        {
                            cardAmount.disabled = true;
                            card.classList.add('d-none');
                        }
                    }
                    if(payMethodVal == "bank" || payMethodVal == "Bank" || payMethodVal == "BANK")
                    {
                        filepicker.addEventListener('click',()=>{
                            filepicker = file.click();
                        });
                        bankAmount.disabled = false;
                        bank.classList.remove('d-none');
                    }
                    else
                    {
                        if(!bank.classList.contains('d-none'))
                        {
                            bankAmount.disabled = true;
                            bank.classList.add('d-none');
                        }
                    }
                    if(payMethodVal == "cash in office" || payMethodVal == "Cash In Office" ||payMethodVal == "Cash in office" || payMethodVal == "CASH IN OFFICE")
                    {
                        cashAmount.disabled = false;
                        cash.classList.remove('d-none');
                    }
                    else
                    {
                        if(!cash.classList.contains('d-none'))
                        {
                            cashAmount.disabled = true;
                            cash.classList.add('d-none')
                        }
                    }
                });
            }
        });
    </script>
@endsection