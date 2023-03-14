@extends('parent')

@section('title','Csv Page')
@section('styles')
    <style>
        td ,th {
            max-width: 1500px;
            min-width: 200px;
            height: auto;
            text-align: center;
        }
    </style>

@endsection
@section('content')
<a href="{{ route('csv.create') }}" class="btn mx-5 btn-primary mb-3">Create + </a>
<a href="{{ route('csv.download') }}" class="btn  btn-info mb-3">download </a>

<form action="{{ route('csv.uploadfile') }}" method="POST" class="mb-3 mx-5" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-6">
            <input type="file" id="name" name="file" class="form-control @error('file') is-invalid @enderror" >
            @error('file')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror    
        </div>
        <div class="col-3">
            <button type="submit" class="btn btn-dark">Upload</button>

        </div>
    </div>
</form>
@if (!$is_empty)
    
<div class="row">
    <div class="table-responsive mb-3">
        <table class="table table-bordered">
            <thead>
                <tr>    
                    @php
                        $titles = $header;
                        @endphp
                    
                        <th style="min-width: 50px ;">#</th>
                        @php
                        for ($i = 1; $i < (count($titles)+1) ; ++$i) {
                            if ($titles[$i-1]) {

                    @endphp
                                <th>
                                    {{ $titles[$i-1] }} <span class="mx-1"></span>
                                    <a class="btn text-danger fw-bold p-0 remove_col"   title="remove column" href="#" data-name="{{ $titles[$i-1] }} " data-id="{{ $i }}"><i class="fas fa-trash"></i></a>
                                    <a class="btn text-white fw-bold p-0 "  title="added column" href="{{ route('csv.create_col', $i) }}" > <i class="fas fa-plus text-primary fw-bold "></i> </a>
                                    <a class="btn  fw-bold p-0 edit_col"   title="update column" href="{{ route('csv.edit_col',$i) }}" > <i class="fas fa-edit text-success fw-bold"></i></a>
                                </th>
                    @php
                            }
                        }
                    @endphp

                </tr>
            </thead>
            <tbody>
                @php
                    $num = 1;
                    $i = 1;
                @endphp
                @foreach ($items as $key=>$product)
                    @php
                        if ($num == 1) {
                            $num++;
                            continue;
                        }
                    @endphp

                    <tr>
                        <td style="min-width: 50px ;">{{ $key }}</td>

                        @foreach ($product as $item)
                            <td >{{ json_encode($item) }}</td>
                        @endforeach

                        <td scope="col">
                            <a class="btn btn-danger delete"  href="#" data-id="{{ $key+1 }}">Delete</a>
                        </td>
                        <td scope="col">
                            <a href="{{ route('csv.edit', $key+1  ) }}" class="btn btn-warning">Edit</a>
                        </td>
                    </tr>
                @endforeach


            </tbody>
        </table>
    </div>
</div>
    {{-- <div class="mx-5">{{ $items->links() }}</div> --}}
@endif

@endsection
@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script>
   $('.delete').click(function() {
        var product_id = $(this).attr('data-id');
        var product_name = $(this).attr('data-name');
        swal({
                title: "Are you sure?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    window.location = "cs/delete/" + product_id 
                    swal("Poof! Your imaginary file has been deleted!", {
                        icon: "success",
                    });
                }
            });
    })

    $('.remove_col').click(function() {
        var product_id = $(this).attr('data-id');
        var product_name = $(this).attr('data-name');
        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover " + product_name,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    window.location = "cs/remove_col/" + product_id + ""
                    swal("Poof! Your imaginary file has been deleted!", {
                        icon: "success",
                    });
                } else {
                    swal("Your imaginary file is safe!");
                }
            });
    })

    $('.added_col').click(function() {
        var product_id = $(this).attr('data-id');
        var product_name = $(this).attr('data-name');
        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to added " + product_name,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    window.location = "cs/added_col/" + product_id + ""
                    swal("Poof! Your imaginary file has been deleted!", {
                        icon: "success",
                    });
                } else {
                    swal("Your imaginary file is safe!");
                }
            });
    })
</script>
<script>
    @if (Session::has('success'))
        toastr.success("{{ Session::get('success') }}")
    @endif
    @if (Session::has('deleted'))
        toastr.deleted("{{ Session::get('deleted') }}")
    @endif
</script>  

@endsection