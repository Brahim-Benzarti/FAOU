@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8" style="text-align:center;">
            <div class="text-danger">Make sure that the file provided follow a certain Heading row. <a href="{{asset('files/template.xlsx')}}">Download Template</a></div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8 dash d-flex justify-content-center align-items-center @error('csvfile') is-invalid @enderror">
            <form id="myform" method="POST" enctype="multipart/form-data">
                @csrf
                <label id="uploadbtn" class="btn btn-primary" for="csvfile">Upload a CSV file</label>
                <input type="file" name="csvfile" id="csvfile" class="hidden" required>
            </form>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8 d-flex justify-content-center bg-danger" style="color:white;">
            @error('csvfile')<strong>{{ $message }}</strong> @enderror
        </div>
    </div>
    <div class="row mt-3">
        <div class="col d-flex justify-content-center">
            <input type="submit" id="submitfile" value="Confirm" class="btn btn-primary" form="myform">
        </div>
    </div>
</div>
<script src="{{asset('js/jquery.js')}}"></script>
<script src="{{asset('js/addapp.js')}}"></script>
<link rel="stylesheet" href="{{asset('css/addapp.css')}}">
@endsection