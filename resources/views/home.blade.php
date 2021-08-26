@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-between">
        <div class="col-lg-3">
            <div class="row justify-content-center">
                <div style="position:relative;width:300px;height:300px;">
                @if(Auth::user()->picture)
                <img class="rounded" src="{{asset("images/users/".Auth::user()->picture)}}" alt="{{Auth::user()->name}}" style="height:100%;width:100%;">
                    @if(Auth::user()->countrycode)
                    <img class="rounded-circle" src="https://flagcdn.com/h120/{{Auth::user()->countrycode}}.png" alt="{{Auth::user()->countrycode}}" title="{{Auth::user()->countrycode}}" style="position:absolute;height:50px;width:60px;bottom:5px;right:5px;">
                    @else
                    <img class="rounded-circle" src="{{asset('images/earth.png')}}" alt="Earth" title="Earth" style="position:absolute;height:50px;width:60px;bottom:5px;right:5px;">
                    @endif
                @else
                <img class="rounded" src="{{asset("images/pp.png")}}" alt="" style="height:100%;width:100%;">
                    @if(Auth::user()->countrycode)
                    <img class="rounded-circle" src="https://flagcdn.com/h120/{{Auth::user()->countrycode}}.png" alt="{{Auth::user()->countrycode}}" title="{{Auth::user()->countrycode}}" style="position:absolute;height:50px;width:60px;bottom:5px;right:5px;">
                    @else
                    <img class="rounded-circle" src="{{asset('images/earth.png')}}" alt="Earth" title="Earth" style="position:absolute;height:50px;width:60px;bottom:5px;right:5px;">
                    @endif
                @endif
                </div>
            </div>
            <div class="row">
                <div class="display-3">{{Auth::user()->name}}</div>
            </div>
            <div>
                <h1>{{Auth::user()->position}}</h1>
                @if($dep_num)
                <h3>Managing</h3>
                <div>
                    <ul>
                        @foreach($departments as $dep)
                        <li>{{$dep[0]}}s</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
            <div class="row justify-content-center">
                <a href="{{route('profileEdit')}}" class="btn btn-primary">Update Profile</a>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">Features</div>
                <div class="card-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col">Pending Applications :</div>
                            <div class="col">
                                @foreach($departments as $dep)
                                <p>{{$dep[0]}}s : {{$dep[1]}}</p> 
                                @endforeach
                            </div>
                            @if(Auth::user()->super)
                            <div class="col">
                                <a href="#" class="btn btn-success">Refer some</a>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <form action="{{Route('newSeason')}}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-primary" >Start a new season</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
