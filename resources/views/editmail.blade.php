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

    <form class="container" method="POST" action="{{route('editingmail')}}" enctype="multipart/form-data" id="myform">
        @csrf
        <div class="btn-group-toggle row justify-content-around" data-toggle="buttons">
            <label class="col-3 btn btn-primary active">
                <input type="radio" name="options" id="option1" value="interview" autocomplete="off" checked>Interview
            </label>
            <label class="col-3 btn btn-primary">
                <input type="radio" name="options" id="option2" value="accept" autocomplete="off">Accept
            </label>
            <label class="col-3 btn btn-primary">
                <input type="radio" name="options" id="option3" value="reject" autocomplete="off">Reject
            </label>
        </div>

        <div class="row flex-column justify-content-center mt-5"> 
            <div class="form-group">
                <label class="ml-2" for="primary">Primary Content</label>
                <textarea class="form-control" name="primary" id="primary" rows="5"></textarea>
            </div>
            <div class="form-group">
                <label class="ml-2" for="secondary">Secondary Content</label>
                <textarea class="form-control" name="secondary" id="secondary" rows="5"></textarea>
            </div>
            <div class="form-group" id="acceptOnly" style="display: none;">
                <label for="files" class="ml-2 mr-4">Attachments</label>
                <label id="files" class="btn btn-primary" aria-disabled="true">
                    <span id="filestext">Upload files</span>
                    <input type="file" name="attachements[]" id="attachements" multiple style="display: none;" disabled>
                </label>
                <span class="text-danger">The file is already there no need to change it.</span>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-sm-2">
                <input id="submit" type="submit" class="btn btn-success" value="Done" style="width:100%">
            </div>
        </div>
    </form>  
    <style>
        label{
            font-size: 25px;
        }
    </style>
    <script>
        $(()=>{
            $('#option1').click(()=>{
                $('#acceptOnly').slideUp();
            });
            $('#option2').click(()=>{
                $('#acceptOnly').slideDown();
            });
            $('#option3').click(()=>{
                $('#acceptOnly').slideUp();
            });
        })
    </script>
@endsection