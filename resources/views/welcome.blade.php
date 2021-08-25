@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col" style="text-align:center;">
            <div class="display-1">Welcome</div>
            <p>This is a workplace reserved only for Admins</p>
            <p>To get access please contact your supervisor for credentials</p>
            <p>Otherwise contact: <a href="mailto:{{$email}}">{{$name}}</a>.</p>
            <div class="display-4">Yet this project will soon be <span class="display-4 text-danger">scaled</span> to a platform for managing recruitment</div>
        </div>
    </div>
</div>
@endsection