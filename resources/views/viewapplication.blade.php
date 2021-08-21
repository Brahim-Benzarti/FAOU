@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-3">
            <img class="rounded-circle" src="{{asset('images/profile_demo.png')}}" alt="" style="width:200px;height:100%;min-height:200px;">
        </div>
    </div>
    <div class="row justify-content-around">
        <div class="col-lg-9 d-flex align-items-center">
            <div class="display-4">{{$application->First_Name}} {{$application->Last_Name}}</div>
        </div>
        <div class="col-lg-3">
            <img src="https://flagcdn.com/h120/{{$countrycode}}.png" alt="{{$countrycode}}" title="{{$country}}">
        </div>
    </div>
    <div class="row justify-content-between mt-5">
        <div class="col-lg-">
            <p>Birthdate: {{$application->Birthday}}</p>
            <p>Nationality: {{$application->Nationality}}</p>
            <p>Position: {{$application->Position}}</p>
            <p>First Time: <span class="text-@if(strtoupper($application->First_Time)=='YES')success @elsedanger @endif">{{$application->First_Time}}</span></p>
        </div>
        <div class="col-lg-">
            @if($application->Email)
                @if(stristr($application->Email,"@"))
                    <p>Email: <a href="mailto:{{$application->Email}}">{{$application->Email}}</a></p>
                @endif
            @endif
            @if($application->CV)
                @if(stristr($application->CV,"www") || stristr($application->CV,"drive"))
                    <p>CV: <a target="_blank" href="@if(!stristr($application->CV,'http')){{__('https://')}}@endif{{$application->CV}}">{{$application->CV}}</a></p>
                @endif
            @endif
        </div>
    </div>
    <div class="row mt-5">
        <div class="col">
            <h3>Biography</h3>
            <p>{{$application->Biography}}</p>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col">
            <h3>Motivation Letter</h3>
            <p>{{$application->Motivation_Letter}}</p>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col d-flex justify-content-around">
            <meta id="id" content="{{$application->id}}">
            <button value="Read" id="Read" class="btn btn-primary"><span></span> <span>Read</span></button>
            <button value="Interview" id="Interview" class="btn btn-success"><span></span> <span>Interview</span></button>
            <button value="Flag" id="Flag" class="btn btn-warning"><span></span> <span>Flag</span> </button>
            <button value="Incomplete" id="Incomplete" class="btn btn-danger"><span></span> <span>Incomplete</span></button>
            <button value="Reject" id="Reject" class="btn btn-danger"><span></span> <span>Reject</span></button>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col d-flex justify-content-center">
            <a href="{{route('ViewApplications')}}"><img src="{{asset('icons/prev.png')}}" alt="previous" id="prev" style="width:50px;height:50px;"></a>
        </div>
    </div>
</div>
<script src="{{asset('js/jquery.js')}}"></script>
<script src="{{asset('js/viewapp.js')}}"></script>
@endsection