@extends('layouts.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Detail of:</h1>
          <p>{{$task_name['text']}}</p>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">.....</li>
            <li class="breadcrumb-item active">Sub Activities</li>
            <li class="breadcrumb-item active">Details</li>
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


        <div class="row">
            <div class="col-md-6">
              <div class="card card-info">
                <div class="card-header">
                  <h3 class="card-title">Time Line</a></h3>
                </div>
                <!-- /. card header -->

                <div class="card-body table-responsive p-0">
                  <table class="table table-hover">

                    <tr align = "left">
                      <th>Date</th>
                      <th>Text</th>
                      <th>By</th>
                    </tr>

                    @foreach($timelines as $timeline)
                    <tr>
                        <td>{{$timeline->created_at}}</td>
                        <td>{{$timeline->text}}</td>
                        <td>{{$timeline->user['name']}}</td>
                    </tr>
                    @endforeach

                  </table>
                </div>
                <!-- /. card body -->
              </div>
              <!-- /. card -->

          </div>
          <!-- /.left col -->

          <!-- Right Col -->
          <div class="col-sm-6">
            <!-- first Table -->
            <div class = "col-sm-12">
              <div class="card card">
                <div class="card-header">
                  <h3 class="card-title">Task Actions</a></h3>
                </div>
                <!-- /. card header -->

                <div class="card-body table-responsive p-0">
                  <table class="table table-hover">
                    <tr align = "left">
                      <td></td>
                      <td><a href="" class="fa fa-hand-point-right" data-toggle="modal" data-target="#assign_staff_modal" data-id = "{{$task_name['id']}}" onclick = "$('#subtask_id').val($(this).data('id'));"></a> Mark as Complete
                      </td>
                    </tr>
                    <tr align = "left">
                      <td></td>
                      <td><a href="" class="fa fa-hand-point-right" data-toggle="modal" data-target="#assign_staff_modal" data-id = "{{$task_name['id']}}" onclick = "$('#subtask_id').val($(this).data('id'));"></a> Assign Staff
                      </td>
                    </tr>
                    <tr align = "left">
                      <td></td>
                      <td><a href="" class="fa fa-hand-point-right" data-toggle="modal" data-target="#assign_staff_modal" data-id = "{{$task_name['id']}}" onclick = "$('#subtask_id').val($(this).data('id'));"></a> Upload Document
                      </td>
                    </tr>
                    <tr align = "left">
                      <td></td>
                      <td><a href="" class="fa fa-hand-point-right" data-toggle="modal" data-target="#assign_staff_modal" data-id = "{{$task_name['id']}}" onclick = "$('#subtask_id').val($(this).data('id'));"></a> Require Approval
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
            <!-- /. left First Table -->
            <!-- Left Second Table -->
            <div class = "col-sm-12">
              <div class="card card">
                <div class="card-header">
                  <h3 class="card-title">Documents</a></h3>
                </div>
                <!-- /. card header -->

                <div class="card-body table-responsive p-0">
                  <table class="table table-hover">
                    <tr>
                      <th>Document Name</th>
                      <th>Date</th>
                      <th>Uploaded by</th>
                    </tr>
                    <tr>
                      <td>Sample Document.docx</td>
                      <td>8 Dec 2019</td>
                      <td>Abdulla Hassan</td>
                    </tr>



                  </table>
                </div>
              </div>
            </div>
            <!-- /. Left Second Table -->
          </div>
          <!-- /. Right Col -->

        </div>
      <!-- /. row -->
      </div>
    <!-- /.Fluid Container -->
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
