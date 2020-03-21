@extends('layouts.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">{{env('IMP_LV6')}} of:</h1>
          <p>ALL</p>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">.....</li>
            <li class="breadcrumb-item active">{{env('IMP_LV5')}}</li>
            <li class="breadcrumb-item active">{{env('IMP_LV6')}}</li>
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

        <div class="col-12">
          <div class="card card-info">
            <div class="card-header">
              <!-- <h3 class="card-title">List</h3> -->

              <!-- <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                  <div class="input-group-append">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div> -->
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
              <table id = "tasks_table" class="table table-hover">
                <thead>
                    <tr align = "left">
                      <th>ID</th>
                      <th>{{env('IMP_LV6')}}</th>
                      <th>Department</th>
                      <th>Budget</th>
                      <th>Start Date</th>
                      <th>Original End Date</th>
                      <th>End Date</th>
                      <th>Progress</th>
                      <th>Action</th>
                    </tr>
                </thead>

                <tbody>
          @foreach($tasks as $task)
                <tr>
                  <td id = "{{$task->id}}" onclick = "location.href='/subtask/'+this.id;">{{$task->id}}</td>
                  <td id = "{{$task->id}}" onclick = "location.href='/subtask/'+this.id;">{{$task->text}}</td>
                  <td id = "{{$task->id}}" onclick = "location.href='/subtask/'+this.id;">{{$task->piu['short_name']}}</td>
                  <td id = "{{$task->id}}" onclick = "location.href='/subtask/'+this.id;">USD {{number_format($task->budget['budget'])}}</td>
                  <td id = "{{$task->id}}" onclick = "location.href='/subtask/'+this.id;">{{$task->start_date}}</td>
                  <td id = "{{$task->id}}" onclick = "location.href='/subtask/'+this.id;"></td>
                  <td id = "{{$task->id}}" onclick = "location.href='/subtask/'+this.id;"></td>
                  <td>{{$task->progress*100}}%</td>
                  <td field-key='action'>
                    <a href="{{ route('pmu.subtask',[$task->id]) }}" class="fa fa-eye"></a>
                    <a href="" class="fa fa-hand-point-right" data-toggle="modal" data-target="#assign_piu_modal" data-id = "{{$task->id}}" onclick = "$('#task_id').val($(this).data('id'));"></a>
                  </td>
                </tr>
          @endforeach
            </tbody>



              </table>
            </div>
            <!-- /.card-body -->
            <!-- Card Footer -->
            <div class="card-footer clearfix">
                <!-- <ul class="pagination pagination-sm m-0 float-right">
                  <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                  <li class="page-item"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                </ul> -->
            </div>
            <!-- /. Card footer -->
          </div>
          <!-- /.card -->
        </div>

      </div>
      <!-- /.row (main row) -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

<!-- Assign piu Modal -->
<div class="modal fade" id="assign_piu_modal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Assign Department</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Address Modal body -->
      <div class="modal-body">
        {!! Form::open(['method' => 'POST',  'files' => false,]) !!}
        <div class="form-group">
          <input type="hidden" name = "task_id" id = "task_id">
          <label for="name">Select Department*</label>
          <select id = "assign_piu" name="assign_piu" class="custom-select">
            @foreach($pius as $piu)
              <option value="{{$piu->id}}" >{{$piu->short_name}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <!-- /. Address Modal body -->

      <!-- Modal footer -->
      <div class="modal-footer">
        <button id = "store_piu" type="submit" class="btn btn-info" data-dismiss="modal">Save</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

      </div>
        {!! Form::close() !!}
    </div>
  </div>
</div>
<!-- /. Assign piu Modal -->

@section('javascript')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script type="text/javascript">
// Start assigned staff Store
$("#store_piu").click(function() {
  var piu_id = $('#assign_piu').val();
  var task_id = $('#task_id').val();
  if(task_id){
        $.ajax({
           type:"get",
           url:"{{url('/assign_piu')}}/"+task_id+"/"+piu_id,
           success:function(res)
           {
                if(res)
                {
                  location.reload();
                }
           }

        });
  }

  // alert(task_id);

});

</script>



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
<!-- DataTables -->

<script src="/dist/plugins/datatables/jquery.dataTables.js"></script>
<script src="/dist/plugins/datatables/dataTables.bootstrap4.js"></script>
<!-- /. Datatables -->
<script>
  $(function () {
    $("#tasks_table").DataTable();

    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
    });
  });
</script>
@stop
