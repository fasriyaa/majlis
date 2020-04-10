@extends('layouts.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">New Meeting</h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href = "/meetings">Meetings</a></li>
            <li class="breadcrumb-item active">New</li>
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
                        <h3 class="card-title">New Memeber Details</h3>
                      </div>
                      <!-- /.card-header -->
                      <!-- form start -->
                      {!! Form::open(['method' => 'POST', 'route' => ['meetings.store'], 'files' => false,]) !!}
                        <div class="card-body">
                          <div class="form-group row">
                            <label  class="col-sm-4 col-form-label">Select Member<font color = "red">*</font></label>
                            <div class="col-sm-8">
                              <select id = "category_id" class="select2"  name="member_id" style="width: 100%;" required>
                                <option value="0" disabled >Select Member</option>
                                  @foreach($members as $member)
                                    <option value="{{$member->id}}" >{{$member->name}} | {{$member->constituency}}</option>
                                  @endforeach
                              </select>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Select Date<font color = "red">*</font></label>
                            <div class="col-sm-8">
                              <input type = "text" id = "datepicker" name = "date" class = "form-control" value = "" required>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Duration (Miniutes)<font color = "red">*</font></label>
                            <div class="col-sm-8">
                              <input type = "number" step = "30" id = "duration" name = "duration" class = "form-control" value = "" required>
                            </div>
                          </div>




                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                          <button type="submit" class="btn btn-info">Submit</button>
                        </div>
                      </form>
                    </div>
                    <!-- /.card -->
                  </div>
        <!-- /. left coloumn -->

        <!-- Right Coloumn -->

        <div class="col-sm-6">

          @if(Session::has('message'))
          <div class = "col-sm-12">
              <p class="alert alert-{{Session::get('label')}}">{{ Session::get('message') }}</p>
          </div>
          @endif

            <div class = "col-sm-12">
              <div class="card card">
                <div class="card-header">
                  <h3 class="card-title">Actions</a></h3>
                </div>
                <!-- /. card header -->

                <div class="card-body table-responsive p-0">
                  <table class="table table-hover">







                  </table>
                </div>
              </div>
            </div>
        </div>

        <!-- /.right coloumn -->





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

  $(document).ready(function () {
      $('#datepicker').daterangepicker({
        uiLibrary: 'bootstrap',
        format: "MM/DD/YYYY h:mm",
        autoclose: true,
        todayBtn: true,
        timePicker: true,
        singleDatePicker: true
      });
  });

  $(function () {
  //Initialize Select2 Elements
  $('.select2').select2()
});

</script>
<!-- Bootstrap 4 -->
<script src="/dist/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="/dist/plugins/morris/morris.min.js"></script>
<!-- select2 plugin -->
<script src="/dist/plugins/select2/select2.full.min.js"></script>
<!-- /select 2 plugin -->
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
