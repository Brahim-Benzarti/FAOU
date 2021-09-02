@extends('layouts.app')

@section('content')
    <div class="container">
        @if($sent)
        <div class="row justify-content-around">
            @foreach ($applicants as $application)
                <label class="col-md-4 col-lg-3 d-flex flex-column align-items-center mt-3" for="btn{{$application->id}}">
                    <img class="rounded-circle" src="{{asset('images/profile_demo.png')}}" alt="" style="width:200px;height:200px;min-height:200px;cursor: pointer;">
                    <img id="as{{$application->id}}" class="rounded-circle" src="{{asset('images/interview_approved.png')}}" style="width:200px;height:200px;min-height:200px;cursor: pointer;position: absolute;@if(!$application->intern)display:none;@endif">
                    <img id="ds{{$application->id}}" class="rounded-circle" src="{{asset('images/interview_denied.png')}}" style="width:200px;height:200px;min-height:200px;cursor: pointer;position: absolute;@if(!$application->rejected)display:none;@endif">
                    <div style="font-size:20px;cursor: pointer;">{{$application->First_Name}} {{$application->Last_Name}}</div>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal{{$application->id}}" style="display:none;" id="btn{{$application->id}}"></button>
                </label>
                <div class="modal fade" id="modal{{$application->id}}">
                    <div class="modal-dialog modal-md modal-dialog-centered ">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="row justify-content-center">
                                    <div class="col-5">
                                        <img class="rounded-circle" src="{{asset('images/profile_demo.png')}}" alt="" style="width:200px;height:100%;min-height:200px;">
                                    </div>
                                </div>
                                <div class="row justify-content-around">
                                    <div class="col-lg-9">
                                        <div style="font-size: 50px;text-align:center;">{{$application->First_Name}} {{$application->Last_Name}}</div>
                                    </div>
                                </div>
                                <div class="row flex-column align-items-center">
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
                            <div class="modal-footer justify-content-around">
                                <a class="btn btn-primary" href="{{route('ViewApplication')}}/{{$application->id}}">Full Application</a>
                                <button class="btn btn-success" id="intern{{$application->id}}"><span id="internload{{$application->id}}"></span> <span>New Intern</span></button>
                                <button class="btn btn-danger" id="decline{{$application->id}}"><span id="declineload{{$application->id}}"></span> <span>Decline</span></button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @else
        <div class="display-2 row justify-content-center">Send interview Emails First</div>
        @endif
        <div class="row justify-content-around mt-5">
            <div class="col-3">
                <a href="{{route('Interviews')}}" class="btn btn-primary" style="width:100%;">@if($sent)Send Again @else Send @endif</a>
            </div>
            @if($sent)
            <div class="col-3">
                <a href="{{route('AcceptanceHome')}}" class="btn btn-success" style="width:100%;">Finish</a>
            </div>
            @endif
        </div>
    </div>
    <script>
        let list=[];
        @foreach($applicants as $application)list.push({{$application->id}});@endforeach
        console.log(list);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(()=>{
            list.forEach(element => {
                $('#intern'+element).click(()=>{
                    $('#internload'+element).addClass('spinner-border spinner-border-sm');
                    $.post(
                        '/intern/'+element,
                        {},
                        (a,b)=>{
                            console.log(a);
                            $('#internload'+element).removeClass('spinner-border spinner-border-sm');
                            $('#ds'+element).fadeOut();
                            $('#as'+element).fadeIn();
                        }
                    )
                });
                $('#decline'+element).click(()=>{
                    $('#declineload'+element).addClass('spinner-border spinner-border-sm');
                    $.post(
                        '/decline/'+element,
                        {},
                        (a,b)=>{
                            console.log(a);
                            $('#declineload'+element).removeClass('spinner-border spinner-border-sm');
                            $('#as'+element).fadeOut();
                            $('#ds'+element).fadeIn();
                        }
                    )
                });
            });
        })
    </script>
@endsection