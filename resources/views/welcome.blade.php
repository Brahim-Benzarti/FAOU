@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col" style="text-align:center;">
            <div class="display-1">Welcome</div>
            <p>This is a workplace reserved only for Admins</p>
            <p>To get access please contact your supervisor for credentials</p>
            <p>Otherwise contact: <a href="mailto:{{$email}}">{{$name}}</a>.</p>
        </div>
    </div>
</div>
@endsection