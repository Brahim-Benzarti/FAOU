@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-lg-7">
            <div class="row flex-column">
                <div class="form-group form-inline">
                    <label class="mr-3" for="number">Number of Interviews</label>
                    <input type="text" id="number" name="number" class="form-control" style="width:50px;">
                </div>
                <div class="form-group">
                    <label for="link">Link of Interviews</label>
                    <input type="text" id="link" name="link" class="form-control">
                    <a class="link-success" href="https://calendly.com/" target="_blank">Make link</a>
                </div>
                <label for="number">People Getting the Invitation</label>
                <div id="people" style="overflow-y:scroll;overflow-x:hidden;height:350px;width:100%;">

                </div>
            </div>
            <div class="row">

            </div>
            <div class="row">

            </div>
        </div>
        <div class="col-lg-5 d-flex align-items-center flex-column">
            <h4>Email Preview</h4>
            {{-- dynamic --}}
            {{-- <div id="mail" style="height:510px;width:100%;position:relative;overflow:scroll;">
                <img src="{{asset('icons/edit.png')}}" alt="edit" style="position:absolute;top:10px;right:10px;">
            </div> --}}

            {{-- static --}}
            <div id="mail" style="height:510px;width:100%;position:relative;">
                <img src="{{asset('images/email_prev.png')}}" alt="" style="width:100%;height:100%;">
            </div>
        </div>
    </div>
    <div class="row align-items-center flex-column mt-4">
        <a id="send" href="#" class="btn btn-primary">Send Interview Emails</a>
        <div class="mt-2">
            <label for="copy">Only Me</label>
            <input type="checkbox" name="copy" id="copy">
        </div>          
        @if(env('MAIL_HOST')=='smtp.googlemail.com')<a target="_blank" href="https://accounts.google.com/b/0/DisplayUnlockCaptcha">Disable Captcha</a>@endif
    </div>
</div>
<script src="{{asset('js/interviews.js')}}"></script>
@endsection