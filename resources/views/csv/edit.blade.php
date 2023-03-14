@extends('parent')

@section('title','Csv Page')

@section('content')

<div class="container">
    <a href="{{ route('csv.index') }}" class="btn btn-primary mb-5">Index Page</a>

    <div class="row">
        <div class="card container">
            <div class="card-body">
                <form method="GET" action="{{ route('csv.update',$id) }}" enctype="multipart/form-data">
                    @php
                        $x = 'A';
                        for ($i=0; $i < count($items[0]) ; $i++) {
                    @endphp 
                              <div class='mb-3'>
                                <label for='exampleInputEmail1' class='form-label'>{{ $titles[$i] }}</label>
                                <input type='text' class='form-control' name="{{ $x++ .$id }}" value="{{json_encode($items[$id-1][$i])  }}" id='exampleInputEmail1' aria-describedby='emailHelp'>
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