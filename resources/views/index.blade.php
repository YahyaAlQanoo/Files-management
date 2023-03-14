
@extends('parent')

@section('title','Home Page')
@section('styles')
    <style>
        .btn-app {
            width: 600px;
            height: 200px; 
        }
        .btn-app span {
            font-size: 100px;
        }
    </style>
@endsection
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <a class="btn btn-app bg-success" href="{{ route('csv.index') }}" >               
               <span>Csv</span> 
              </a>
              <a class="btn btn-app bg-primary" href="{{ route('excel.index') }}"  >
                <span>Excel</span>
            </a>
              <a class="btn btn-app bg-warning" href="{{ route('xml.index') }}"  >
                <span>Xml</span>
            </a>
              <a class="btn btn-app bg-secondary"  href="{{ route('json.index') }}" >
                  <span>Json</span>
              </a>



          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>


@endsection
<!-- /.content -->

