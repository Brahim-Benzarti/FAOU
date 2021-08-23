@foreach($applications as $application)
<div class="row mt-3" style="min-height:200px;">
    <div class="col-lg-3 d-flex justify-content-center">
        <img class="rounded-circle" src="{{asset('images/profile_demo.png')}}" alt="" style="width:200px;height:100%;min-height:200px;">
    </div>
    <div class="col-lg-9">
        <div class="row">
            <div class="col-11 d-flex flex-column justify-content-around" style="height:200px;background-color:rgb(218, 235, 255)">
                <div class="row">
                    <div class="col">
                        <div class="display-4">{{$application->First_Name}} {{$application->Last_Name}}</div>
                    </div>
                </div>
                <div class="row justify-content-between">
                    @if($application->seen!=0)
                    <div class="col">
                        @for($i=1;$i<=$application->stars;$i++)
                        <img src="@if($i==5){{asset('icons/fifthstar.png')}}@else{{asset('icons/star.png')}}@endif" alt="star">
                        @endfor
                    </div>
                    @endif
                    <div class="col d-flex justify-content-between">
                        @if($application->seen==1) <img src="{{asset('icons/seen.png')}}" alt="seen"> @endif
                        @if($application->seen==0) <img src="{{asset('icons/notseen.png')}}" alt="notseen"> @endif
                        @if($application->incomplete==1) <img src="{{asset('icons/incomplete.png')}}" alt="incomplete"> @endif
                        @if($application->flag==1) <img src="{{asset('icons/flag.png')}}" alt="flag"> @endif
                        @if($application->rejected==1) <img src="{{asset('icons/rejected.png')}}" alt="rejected"> @endif
                        @if($application->accepted==1) <img src="{{asset('icons/accepted.png')}}" alt="accepted"> @endif
                    </div>
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
            <li class="page-item @if($current_page==1) disabled @endif"><a class="page-link" href="#" @if($doing=="pending") onclick="@if($current_page>1)pendingShow({{$current_page-1}});@else # @endif" @elseif($doing=="seen") onclick="@if($current_page>1)seenShow({{$current_page-1}});@else # @endif" @endif >Previous</a></li>
            @for($i=1;$i<=$pages;$i++)
            <li class="page-item @if($current_page==$i) disabled @endif"><a class="page-link" href="#" @if($doing=="pending") onclick="pendingShow({{$i}});" @elseif($doing=="seen") onclick="seenShow({{$i}});" @endif>{{$i}}</a></li>
            @endfor
            <li class="page-item @if($current_page==$pages) disabled @endif"><a class="page-link"  href="#" @if($doing=="pending") onclick="@if($current_page<$pages)pendingShow({{$current_page+1}});@else # @endif" @elseif($doing=="seen") onclick="@if($current_page<$pages)seenShow({{$current_page+1}});@else # @endif" @endif>Next</a></li>
        </ul>
    </div>
</div>
