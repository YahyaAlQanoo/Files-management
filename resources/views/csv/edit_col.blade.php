@extends('parent')

@section('title','Csv Page')

@section('content')

<form action="{{ route('csv.update_col',$id) }}" method="GET">
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">Edit Column Name</label>
      <input type="text" name="col_name" value="{{ $title }}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
@endsection