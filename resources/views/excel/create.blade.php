@extends('parent')

@section('title','Json Page')

@section('content')


<div class="container">
    <a href="{{ route('excel.index') }}" class="btn btn-primary mb-5">Home Page</a>

    <div class="row">
        <div class="card container">
            <div class="card-body">
                <form method="POST" action="{{ route('excel.store') }}" enctype="multipart/form-data">
                    @csrf
                    @php
                        $x = 'A';
                        for ($i=0; $i < $count_col; $i++) {
                    @endphp 
                              <div class='mb-3'>
                                <label for='exampleInputEmail1' class='form-label'>{{ $titles[$i] }}</label>
                                <input type='text' class='form-control' name="{{ $x++ .$count_row }}" id='exampleInputEmail1' aria-describedby='emailHelp'>
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