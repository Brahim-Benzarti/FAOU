@extends('layouts.app')

@section('content')
<style>
    .change{
        margin:0px;
        height:100%;
        width:100%;
        visibility: visible;
        transition: 0.5s;
    }
    .change:hover{
        background-color: rgb(0, 183, 255, 0.5);
        background-image: url({{asset('images/ppchange.png')}});
        background-size: 50%;
        background-position:center;
        background-repeat: no-repeat;
    }
    .none{
        display: none;
    }
</style>
<div class="container">
    <div class="row align-items-center flex-column">
        <div style="position:relative;width:300px;height:300px;">
            @if(Auth::user()->picture)
            <img id="profile_picture" class="pp rounded-circle" src="{{asset("images/users/".Auth::user()->picture)}}" alt="{{Auth::user()->name}}" style="width:100%;height:100%;">
            @else
            <img id="profile_picture" class="pp rounded-circle" src="{{asset("images/pp.png")}}" alt="" style="width:100%;height:100%;">
            @endif
            <label for="pp" class="rounded-circle change" style="position:absolute;bottom:0px;right:0px;">
                <form class="none" enctype="multipart/form-data">
                    @csrf
                    <input type="file" id="pp">
                </form>
            </label>
        </div>
        
        <div class="row justify-content-between">
            <div class="d-flex justify-content-center col-lg-10">
                <div class="display-3">{{Auth::user()->name}}</div>
            </div>
            <div class="d-flex justify-content-center col-lg-2">
                @if(Auth::user()->countrycode)
                <img class="rounded" src="https://flagcdn.com/h120/{{Auth::user()->countrycode}}.png" alt="{{Auth::user()->countrycode}}" title="{{Auth::user()->countrycode}}" style="height:80px;width:140px;">
                @else
                <img class="rounded" src="{{asset('images/earth.png')}}" alt="Earth" title="Earth" style="height:80px;width:140px;">
                @endif
            </div>
        </div>
    </div>
    <div class="row justify-content-center mt-4">
        <div class="card col-md-6" style="padding:0px;">
            <div class="card-header">General Information</div>
            <form id="infoform" class="card-body d-flex flex-column align-items-center" method="POST">
                @csrf
                <div class="form-group">
                    <label for="country">Country of origin: </label>
                    <input placeholder="{{Auth::user()->country}}" class="form-control" type="text" name="country" id="country">
                </div>
                <div class="form-group">
                    <label for="tel">Phone Number: </label>
                    <input placeholder="{{Auth::user()->number}}" class="form-control" type="text" name="tel" id="tel">
                </div>
                <button class="btn btn-primary" id="submit" type="submit"><span id="spinner"></span>  <span>Submit</span></button>
            </form>
        </div>
    </div>
</div>
<script src="{{asset('js/jquery.js')}}"></script>
<script src="{{asset('js/Pupdate.js')}}"></script>
@endsection