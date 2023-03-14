@extends('parent')

@section('title','Json Page')

@section('content')

<div class="container">
    <a href="{{ route('json.index') }}" class="btn btn-primary mb-5">Index Page</a>

    <div class="row">
        <div class="card container">
            <div class="card-body">
                <form method="GET" action="{{ route('json.update',$id) }}" enctype="multipart/form-data">
                    @php
                        for ($i=1; $i <= count($information) ; $i++) {
                    @endphp 
                              <div class='mb-3'>
                                <label for='exampleInputEmail1' class='form-label'>{{ $information[$i] }}</label>
                                <input type='text' class='form-control' name="{{ $information[$i] }}" value="{{json_encode($data[$information[$i]])  }}" id='exampleInputEmail1' aria-describedby='emailHelp'>
                              </div>
                    @php    
                        }
                    @endphp



                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

</div>

@endsection