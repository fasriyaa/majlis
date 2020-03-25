@extends('layouts.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Users</h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="/users">Users</a></li>
            <li class="breadcrumb-item active">Attach a Role</li>
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

                    <div class="card card-info card-outline">
                          <div class="card-header">
                            <h3 class="card-title">Select Roles</h3>

                            <div class="card-tools">
                              <!-- <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button> -->
                            </div>
                          </div>
                          <!-- /.card-header -->
                          {!! Form::open(['method' => 'POST', 'route' => ['roles.attach_user_store'], 'files' => false]) !!}
                          <input type = "hidden" name="user_id" value = "{{$user['id']}}">
                          <div class="card-body">
                            <div class="row">
                              <div class="col-12">
                                <div class="form-group">
                                  <!-- <label>Multiple</label> -->
                                  <select class="duallistbox" multiple="multiple" name = "roles_id[]">
                                    @foreach($roles as $role)
                                      <?php $sel = "";?>
                                      @foreach($user['roles'] as $prole)
                                        @if($prole['id']==$role->id)
                                          <?php $sel = "selected"; break; ?>
                                        @else
                                          <?php $sel = ""; ?>
                                        @endif
                                      @endforeach
                                      <option value="{{$role->id}}" {{$sel}}>{{$role->name}}</option>
                                    @endforeach
                                  </select>
                                </div>
                                <!-- /.form-group -->
                              </div>
                              <!-- /.col -->
                            </div>
                            <!-- /.row -->
                          </div>
                          <!-- /.card-body -->
                          <div class="card-footer">
                            <!-- can('Create Permission') -->
                              <button type="submit" class="btn btn-info">Update</button>
                            <!-- endcan -->
                          </div>
                        </div>
                        </form>
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
                              <p>User ID : <font color = "#176781">{{$user['id']}}</font></p>
                              <p>User Name : <font color = "#176781">{{$user['name']}}</font></p>
                              <p>User Mail : <font color = "#176781">{{$user['email']}}</font></p>
                              <p>Organization : <font color = "#176781">{{$user['organization']}}</font></p>
                              <p>Designation : <font color = "#176781">{{$user['designation']}}</font></p>
                              <table class="table table-condensed">

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

  $(function () {
    //Bootstrap Duallistbox
   $('.duallistbox').bootstrapDualListbox()

  })

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
<!-- duallistbox bootsrap4 -->
<script src="/dist/plugins/duallistbox/jquery.duallistbox.min.js"></script>
<!-- /.duallistbox bootsrap4 -->
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
