@extends('layouts.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">{{env('IMP_LV7')}} of:</h1>
          <p>{{$task['text']}} | {{$subactivity['text']}}</p>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active"><a href = "/components">{{env('IMP_LV2')}}</a></li>
            <li class="breadcrumb-item active"><a href = "/subcomponent/{{$subcomponent['parent']}}">{{env('IMP_LV3')}}</a></li>
            <li class="breadcrumb-item active"><a href = "/activity/{{$activity['parent']}}">{{env('IMP_LV4')}}</a></li>
            <li class="breadcrumb-item active"><a href = "/subactivity/{{$subactivity['parent']}}">{{env('IMP_LV5')}}</a></li>
            <li class="breadcrumb-item active"><a href = "/task/{{$task['parent']}}">{{env('IMP_LV6')}}</a></li>
            <li class="breadcrumb-item active">{{env('IMP_LV7')}}</li>
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
              <h3 class="card-title">List</a></h3>

              <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                  <div class="input-group-append">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
              <table class="table table-hover">

                <tr align = "left">
                  <th>ID</th>
                  <th></th>
                  <th>{{env('IMP_LV7')}}</th>
                  <th>Assigned To </th>
                  <th>Start Date</th>
                  <th>End Date</th>
                  <th>Progress</th>
                  <th>Action</th>
                </tr>

          @foreach($subtasks as $subtask)
                <tr>
                  <?php
                    if($subtask->progress == 1)
                    {
                      $check = "checked";
                      $color = "green";
                    }else {
                      $check = "";
                      $color = "";
                    }
                  ?>
                  <td><font color = {{$color}}>{{$subtask->id}}</font></td>
                  <td>
                      <input id="{{$subtask->id}}" class="form-check-input" onclick="update_progress(this);" type="checkbox" {{$check}}>
                  </td>
                  <td><font color = {{$color}}>{{$subtask->text}}</font></td>
                  <td><font color = {{$color}}>{{$subtask->user['name']}}</font></td>
                  <td><font color = {{$color}}>{{date("d-M-Y", strtotime($subtask->start_date))}}</font></td>
                  <td><font color = {{$color}}>{{date("d-M-Y", strtotime("+".$subtask->duration." days", strtotime($subtask->start_date)))}}</font></td>
                  <td><font color = {{$color}}>{{$subtask->progress*100}}%</font></td>
                  <td field-key='action'>
                    <a href="{{ route('pmu.task_timeline',[$subtask->id]) }}" class="fa fa-eye"></a>
                    <a href="" class="fa fa-hand-point-right" data-toggle="modal" data-target="#assign_staff_modal" data-id = "{{$subtask->id}}" onclick = "$('#subtask_id').val($(this).data('id'));"></a>
                    <a href="{{ route('gantt.editSubtask',[$subtask->id]) }}" class="fa fa-edit"></a>
                  </td>
                </tr>
          @endforeach



              </table>
            </div>
            <!-- /.card-body -->
            <!-- Card Footer -->
            <div class="card-footer clearfix">
              <div class = "row">
                  <div class = "col-sm-11">
                        <a href = "/add_subtask/{{$task['id']}}"><button type="button" class="btn btn-info float-right"><i class="fa fa-plus"></i> Add</button></a>
                      </div>
                      <div class = "col-sm-1">
                        <a href = "/reorder_task/{{$task['id']}}"><button type="button" class="btn btn-info float-right">Reorder</button></a>
                      </div>
                      <!-- <div class = "col-sm-1">
                        <a href = "/reorder_task/{{$task['id']}}"><button type="button" class="btn btn-info float-right">&nbsp Gantt &nbsp</button></a>
                      </div> -->
              </div>

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

<!-- Assign Staff Modal -->
<div class="modal fade" id="assign_staff_modal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Assign Staff</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Address Modal body -->
      <div class="modal-body">
        {!! Form::open(['method' => 'POST',  'files' => false,]) !!}
        <div class="form-group">
          <input type="hidden" name = "subtask_id" id = "subtask_id">
          <label for="name">Select Staff*</label>
          <select id = "assign_staff" name="assign_staff" class="custom-select">
            @foreach($users as $user)
              <option value="{{$user->id}}" >{{$user->name}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <!-- /. Address Modal body -->

      <!-- Modal footer -->
      <div class="modal-footer">
        <button id = "store_staff" type="submit" class="btn btn-info" data-dismiss="modal">Save</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

      </div>
        {!! Form::close() !!}
    </div>
  </div>
</div>
<!-- /. Assign Staff Modal -->





@section('javascript')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script type="text/javascript">
// Start assigned staff Store
$("#store_staff").click(function() {
  var staff_id = $('#assign_staff').val();
  var subtask_id = $('#subtask_id').val();
  if(staff_id){
        $.ajax({
           type:"get",
           url:"{{url('/assign_staff')}}/"+subtask_id+"/"+staff_id,
           success:function(res)
           {
                if(res)
                {
                  location.reload();
                }
           }

        });
  }
});

//Marking the task complete
function update_progress(object)
{
  if(object.checked)
    {
      var progress = 1;
    }else {
        var progress = 0;
    }
    var subtask_id = object.id;

    if(subtask_id){
          $.ajax({
             type:"get",
             url:"{{url('/update_progress')}}/"+subtask_id+"/"+progress,
             success:function(res)
             {
                  if(res)
                  {
                    location.reload();
                    // alert("ok");
                  }
             }


          });
    }
}

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
@stop
