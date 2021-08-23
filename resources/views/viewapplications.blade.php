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
    <div class="row">
        <div class="col-lg-2">
            <div class="row">
                <div class="col">
                    <h3>Filters</h3><hr>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h4>Seen </h4>
                    <label for="seen0">No</label>
                    <input class="form-contorl" id="seen0" type="radio" name="seen" value="0" checked>
                    <label for="seen1">Yes</label>
                    <input class="form-contorl" id="seen1" type="radio" name="seen" value="1">
                    <div id="slider" style="display:none;">
                    <div id="forseen1" class="d-flex flex-column" >
                        <div>
                            <input class="form-contorl" type="checkbox" name="Rejected" id="Rejected">
                            <label for="Rejected">Rejected</label>
                        </div>
                        <div>
                            <input class="form-contorl" type="checkbox" name="Accepted" id="Accepted">
                            <label for="Accepted">Accepted</label>
                        </div>
                        <div>
                            <input class="form-contorl" type="checkbox" name="Incomplete" id="Incomplete">
                            <label for="Incomplete">Incomplete</label>
                        </div>
                        <div>
                            <input class="form-contorl" type="checkbox" name="Flagged" id="Flagged">
                            <label for="Flagged">Flagged</label>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col">
                    <h3>Info</h3><hr>
                </div>
            </div>
            <div class="row">
                <div class="col d-flex flex-column">
                    <div class="col" style="padding:0;">
                        Accepted: {{$accepted}}
                    </div>
                    <div class="col" style="padding:0;">
                        Rejected: {{$rejected}}
                    </div>
                    <div class="col" style="padding:0;">
                        Incomplete: {{$incomplete}}
                    </div>
                    <div class="col" style="padding:0;">
                        Flagged: {{$flag}}
                    </div>
                    <div class="col" style="padding:0;">
                        Pending: {{$seen}}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-10 d-flex flex-column jutify-content-center" id="preview"></div>
    </div>

    


</div>
<script src="{{asset('js/jquery.js')}}"></script>
<script src="{{asset('js/interviews.js')}}"></script>
@endsection