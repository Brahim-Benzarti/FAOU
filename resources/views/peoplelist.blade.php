@foreach($applications as $application)
<a href="{{route('ViewApplication')}}/{{$application->id}}" target="_blank" class="row mt-2">
    <div class="col-2">
        <img class="rounded-circle" src="{{asset('images/profile_demo_small.png')}}" alt="Profile pic" style="width:100%;height:100%;">
    </div>
    <div class="col-10">
        <div class="row">
            <h4>{{$application->First_Name}} {{$application->Last_Name}}</h4>
        </div>
        <div class="row">
            @for($i=1;$i<=5;$i++)
                <img src="@if($i==5){{asset('icons/fifthstar.png')}}@else{{asset('icons/star.png')}}@endif" id="{{'star'.$i}}" style="height:30px;width:30px; @if($application->stars<$i) opacity:0.3; @endif">
            @endfor
        </div>
    </div>
</a>
@endforeach