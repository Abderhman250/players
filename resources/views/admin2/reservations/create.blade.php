@extends('admin.layouts.master')
@section('title')
Add
@endsection
@section('body')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 style="color: #11304e">Add Reservationes</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a  href="{{ url('admin/home') }}">Home</a></li>
            <li class="breadcrumb-item active">Add Reservationes</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          @if(Session::has('errors'))
          <div style="background: #11304e; border: none;" class="alert alert-success" role="alert">
            <h4 class="alert-heading"> validation!</h4>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </div>
          @endif 

          @if(isset($error))
          <div style="background: #11304e; border: none;" class="alert alert-success" role="alert">

        </div> 
          @endif
          <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
         @if(isset($success))
         <script>
          swal({
            title: "Good job!",
            text: "You clicked the button!",
            icon: "success",
            button: "Aww yiss!",
          });
         </script>
        @endif  
          @if(Session::has('error'))
          <div class="alert alert-danger">
            {{Session::get('error')}}
          </div>
          @endif
          <!-- jquery validation -->
          <div class="card card-primary">
            <div class="card-header" style="background: #11304e;">
              <h3 class="card-title">Add <small>Reservationes</small></h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->

            <form id="quickForm" method="POST" action="{{ route('reservations.store') }}">
              {!! csrf_field() !!}
              <div class="card-body" style="color: #11304e;">

                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <div class="row">
                        <div class="col-sm-12">
                            <label for="appt">For:</label>

                            <input type="time" id="appt" class="form-control" name="start"  required>
                                                 </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="form-group">
                      <div class="row">
                        <div class="col-sm-12">
                            <label for="appt">TO:</label>

                            <input type="time" id="appt" class="form-control" name="end"
                                  required>
                                                 </div>
                      </div>
                    </div>
                  </div>
              </div>


          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <div class="row">
                  <div class="col-sm-12">
                    <label for="exampleInputEmail1">Date</label>
                    <input type="date" name="date" class="form-control" id="exampleInputEmail1" placeholder="Enter Scout">
                  </div>
                </div>
              </div>
            </div>
            @if(Auth::user()->role_id  == 1)
              <div class="col-lg-6">
              <div class="form-group">
                <label>{{ trans('messeges.role') }}</label>
                <select class="custom-select" name="dr_id">
                  <option value="0" >Choose role...</option>
                  @foreach($Doctors as $Doctor)
                  <option value="{{$Doctor->id}}">{{$Doctor->name}}</option>
                  @endforeach
                </select>
              </div>
              
              @else
              <input type="hidden" value ={{ Auth::user()->id}} name="dr_id">
    
      
            @endif
          </div>
        </div>





        </div>


      </div>
      <!-- /.card-body -->
      <div class="card-footer">
        <button style="background: #11304e; border: none;" type="submit" class="btn btn-primary">Add Reservationes</button>
      </div>
    </form>
  </div>
  <!-- /.card -->
</div>
<!--/.col (left) -->
<!-- right column -->
<div class="col-md-6">

</div>
<!--/.col (right) -->
</div>
<!-- /.row -->
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
@stop