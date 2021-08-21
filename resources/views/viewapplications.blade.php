@extends('layouts.app')

@section('content')
@if (count($errors) > 0)
   <div class = "alert alert-danger">
      <ul>
         @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
         @endforeach
      </ul>
   </div>
@endif

<div class="container">
    <form method="post" id="myform">
        @csrf
    <div class="row form-row justify-content-center">
        <div class="col-md-6 form-group form-inline d-flex justify-content-around">
            <label for="status">Status</label>
            <select class="form-control" name="status" id="status">
                <option value="0" @if($status=="0") selected @endif>All</option>
                <option value="1" @if($status=="1") selected @endif>Read</option>
                <option value="2" @if($status=="2") selected @endif>Pending</option>
            </select>
            <label for="decision">Decision</label>
            <select class="form-control" name="decision" id="decision">
                <option value="2" @if($decision=="2") selected @endif>None</option>
                <option value="1" @if($decision=="1") selected @endif>Accepted</option>
                <option value="0" @if($decision=="0") selected @endif>Rejected</option>
            </select>
            <label for="flag">Only flaged</label>
            <input type="checkbox" name="flag" id="flag" class="form-control">
            
        </div>
    </div>
    </form>


    <div class="row justify-content-around">
        <div class="col-xs-2">
            Total Accepted: {{$accepted}}
        </div>
        <div class="col-xs-2">
            Total Pending: {{$pending}}
        </div>
    </div>

    @if(count($applications)>0)
    @foreach($applications as $application)
    <div class="row mt-3" style="min-height:200px;">
        <div class="col-lg-3 d-flex justify-content-center">
            <img class="rounded-circle" src="{{asset('images/profile_demo.png')}}" alt="" style="background-color:red;width:200px;height:100%;min-height:200px;">
        </div>
        <div class="col-lg-9">
            <div class="row">
                <div class="col-11 d-flex flex-column justify-content-around" style="height:200px;background-color:rgb(218, 235, 255)">
                    <div class="row">
                        <div class="col">
                            <div class="display-4">{{$application->First_Name}} {{$application->Last_Name}}</div>
                        </div>
                    </div>
                    <div class="row justify-content-around">
                        <h3 class="col-sm-">{{$application->status}}</h3>
                        <h3 class="col-sm-">@if($application->decision){{$application->decision}}@endif</h3>
                    </div>
                </div>
                <div class="col-1 d-flex align-items-center"style="background-color:rgb(218, 235, 255);border-radius:0 100% 100% 0">
                    <a href="{{route('ViewApplication')}}/{{$application->id}}" rel="noopener noreferrer">
                        <img src="{{asset('icons/next.png')}}" alt="" style="width:100%">
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <div class="row mt-4">
        <div class="col d-flex justify-content-center">
            <ul class="pagination">
                <li class="page-item @if($current_page==1) disabled @endif"><label class="page-link" href="#" for="@if($current_page>1){{'a'.$current_page-1}}@else # @endif">Previous</label></li>
                @for($i=1;$i<=$pages;$i++)
                <li class="page-item @if($current_page==$i) disabled @endif"><a class="page-link" id="{{'a'.$i}}" href="{{route('ViewApplications')}}/{{$i}}">{{$i}}</a></li>
                @endfor
                <li class="page-item @if($current_page==$pages) disabled @endif"><a class="page-link" href="@if($current_page<$pages) {{route('ViewApplications')}}/{{$current_page+1}} @else # @endif">Next</a></li>
            </ul>
        </div>
    </div>
    

    @else
    <div class="row">
        <div class="col" style="text-align:center">
            <div class="display-2">Nothing Here Yet!</div>
            <!-- <a href="{{route('AddApplications')}}">Add Applicants</a> -->
        </div>
    </div>
    @endif


<script src="{{asset('js/jquery.js')}}"></script>
<script src="{{asset('js/viewapp.js')}}"></script>
</div>
@endsection