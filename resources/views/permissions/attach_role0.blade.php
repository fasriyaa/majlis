@extends('layouts.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Permission</h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="/permissions">Permissions</a></li>
            <li class="breadcrumb-item active">Attach a role</li>
          </ol>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->

      <!-- Main row -->
      <div class="row">

        <!-- left column -->
                  <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-info">
                      <div class="card-header">
                        <h3 class="card-title">Attach Permission to a Role</h3>
                      </div>
                      <!-- /.card-header -->
                      <!-- form start -->
                      {!! Form::open(['method' => 'POST', 'route' => ['permissions.store'], 'files' => false]) !!}
                        <div class="card-body">


                          <div class="form-group">
                            <label for="name">Roles</label>
                            <select id = "type" name="module_id" class="custom-select">
                              @foreach($roles as $role)
                                <option value="{{$role->id}}" >{{$role->name}}</option>
                              @endforeach
                            </select>
                          </div>

                          @if(Session::has('message'))
                              <p class="alert alert-{{Session::get('label')}}">{{ Session::get('message') }}</p>
                          @endif

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                          <!-- can('Create Permission') -->
                            <button type="submit" class="btn btn-info">Attach</button>
                          <!-- endcan -->
                        </div>
                      </form>
                    </div>
                    <!-- /.card -->
                  </div>
        <!-- /. left coloumn -->

        <!-- Right column -->
                  <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card">
                      <div class="card-header">
                        <h3 class="card-title"><font color = "#176781"> Selected Permission Details</font></h3>
                      </div>
                      <!-- /.card-header -->

                        <div class="card-body">
                          <div class="form-group">
                              <p>Permission ID : <font color = "#176781">{{$permissions['id']}}</font></p>
                              <p>Permission Name : <font color = "#176781">{{$permissions['name']}}</font></p>
                              <p>Module : <font color = "#176781">{{$permissions['module']['name']}}</font></p>
                              <table class="table table-condensed">
                                <p>Attached Roles:

                                @foreach($permissions['roles'] as $roles)
                                  <p>
                                    <font color = "#176781">
                                        - {{$roles['name']}}
                                    </font>
                                  </p>
                                @endforeach

                              </table>
                          </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">

                        </div>
                    </div>
                    <!-- /.card -->
                  </div>
        <!-- /. Right coloumn -->





      </div>
      <!-- /.row (main row) -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('javascript')
<!-- jQuery -->
<script src="/dist/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)

</script>
<!-- Bootstrap 4 -->
<script src="/dist/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="/dist/plugins/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="/dist/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="/dist/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="/dist/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="/dist/plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="/dist/plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="/dist/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="/dist/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="/dist/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="/dist/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/dist/js/demo.js"></script>
@stop
