@extends('parent')

@section('title','CSV Page')

@section('content')
<form action="{{ route('csv.added_col',$id) }}" method="GET">
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">Create Column Name</label>
      <input type="text" name="col_name"  class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
@endsection