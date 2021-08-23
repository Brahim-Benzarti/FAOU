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
            @if($countrycode==0)
            <img src="{{asset('images/earth.png')}}" alt="Earth" title="{{$country}}">
            @else
            <img src="https://flagcdn.com/h120/{{$countrycode}}.png" alt="{{$countrycode}}" title="{{$country}}">
            @endif
        </div>
    </div>
    <div class="row justify-content-between mt-5">
        <div class="col-lg-">
            <p>Birthdate: {{$application->Birthday}}</p>
            <p>Nationality: {{$application->Nationality}}</p>
            <p>Position: {{$application->Position}}</p>
            <p>First Time: <span class="@if(strtoupper($application->First_Time)=='YES') text-success @else text-danger @endif">{{$application->First_Time}}</span></p>
        </div>
        <div class="col-lg-">
            @if($application->Email)
                @if(stristr($application->Email,"@"))
                    <p>Email: <a href="mailto:{{$application->Email}}">{{$application->Email}}</a></p>
                @endif
            @endif
            @if($application->CV)
                @if(stristr($application->CV,"drive") || stristr($application->CV,"linkedin") || stristr($application->CV,"docs"))
                    <p>CV: <a target="_blank" href="@if(!stristr($application->CV,'http')){{__('https://')}}@endif{{$application->CV}}">{{$application->CV}}</a></p>
                @else
                @if(stristr($application->CV,"http") || stristr($application->CV,"www"))
                <p>CV (Please check the link name before openning): <a class="link-danger" target="_blank" href="@if(!stristr($application->CV,'http')){{__('https://')}}@endif{{$application->CV}}">{{$application->CV}}</a></p>
                @endif
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
    <div class="row mt-5 justify-content-between">
        <div class="col">
            @for($i=1;$i<=5;$i++)
            <img src="@if($i==5){{asset('icons/fifthstar.png')}}@else{{asset('icons/star.png')}}@endif" id="{{'star'.$i}}" style="@if($application->stars<$i) opacity:0.3 @endif">
            @endfor
        </div>
        <div class="col d-flex justify-content-around">
            <meta id="id" content="{{$application->id}}">
            <button value="Flag" id="Flag" class="btn btn-warning"><span></span> <span>Flag</span> </button>
            <button value="Incomplete" id="Incomplete" class="btn btn-danger"><span></span> <span>Incomplete</span></button>
            <button value="Interview" id="Interview" class="btn btn-success"><span></span> <span>Interview</span></button>
            <button value="Reject" id="Reject" class="btn btn-danger"><span></span> <span>Reject</span></button>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col d-flex justify-content-center">
            <a href="{{route('viewdefault')}}"><img src="{{asset('icons/prev.png')}}" alt="previous" id="prev" style="width:50px;height:50px;"></a>
        </div>
    </div>
</div>
<script src="{{asset('js/jquery.js')}}"></script>
<script src="{{asset('js/viewapp.js')}}"></script>
@endsection