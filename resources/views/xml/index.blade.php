@extends('parent')

@section('title','Xml Page')
@section('styles')
    <style>
        td ,th {
            max-width: 1300px;
            min-width: 100px;
            height: auto;
            text-align: center;
        }
    </style>

@endsection
@section('content')

        <a href="{{ route('xml.create') }}" class="btn btn-primary mx-5 mb-3">Create + </a>
    
        <a href="{{ route('xml.download') }}" class="btn btn-info mb-3">download </a>

        <form action="{{ route('xml.uploadfile') }}" class="mx-5" method="POST" enctype="multipart/form-data">
            <div class="row container">
                @csrf
                    <div class="col-9">
                        <input type="file" id="name" name="file" class="form-control   @error('file') is-invalid @enderror" >
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                    </div>
                    <div class="col-3">
                        <button type="submit" class="btn btn-dark ">Upload</button>
                    </div>
            </div>
        </form>
        <form action="{{ route('xml.uploadfromlink') }}" class="my-2 mx-5" method="post" >
          @csrf
          <div class="row mx-auto">
            <div class="col-9">
              <input type="text" id="name" name="xml" placeholder="Enter Link Of Xml" class="form-control @error('xml') is-invalid @enderror" >
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
                          @if (!empty($information) )
 
                          <th style="min-width: 50px ;">#</th>
                          @foreach ($information as $dat)
                                  <th>{{ $dat   }}</th>
                                @endforeach        
                            @endif
             
    
                        </tr>
                    </thead>
                    <tbody>
                        @if ($arrOutput)
                            
                    
                            

                        @foreach ($arrOutput as $key=>$pro)
                            <tr>
                                <td style="min-width: 50px ;">{{ $key +1 }}</td>
                                @php
                                for ($i=1; $i <= count($information) ; $i++) { 
                            @endphp
                                 <td>{{json_encode($pro[$information[$i]]) ?? '--' }}</td>
                            @php 
                                }
                            @endphp 
                                                      <td scope="col">
                                                        <a class="btn btn-danger delete" data-id="{{ $key }}" href="#">Delete</a>
                                                    </td>
                                                    <td scope="col">
                                                        <a href="{{ route('xml.edit', $key ) ?? '' }}" class="btn btn-warning">Edit</a>
                                                    </td>
                            </tr>
                            
    
                        @endforeach
                        @endif
                       
                    </tbody>
                </table>
            </div>

        </div>

            <div class="mx-5">{{ $arrOutput->links() }}</div> 
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
                swal({
                        title: "Are you sure?",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            window.location = "xm/destroy/" + product_id + ""
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
        </script> 
    
    
    @endsection
    