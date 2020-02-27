@extends('layouts.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <?php
            if($discussion->type == 5)
            {
              $title = "EXCO View | Meeting on: ". date('d M Y', strtotime($discussion->updated_at));
            }
          ?>
          <h1 class="m-0 text-dark">{{$title}}</h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Discussions</li>
            <li class="breadcrumb-item active">EXCO</li>
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
              <h3 class="card-title">List</h3>

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

                <tr>
                  <th>#</th>
                  <th>Tasks</th>
                  <th>Previous Status | {{date('d M Y', strtotime($last_discussion->updated_at))}}</th>
                  <th>Current Status | {{date('d M Y', strtotime($discussion->updated_at))}} </th>
                  <th>Progress</th>
                  <!-- <th>Action</th> -->
                </tr>
              <?php $count = 1; ?>

              @foreach($tasks as $task)
                <tr>
                    <td>{{$count}}</td>
                    <td>
                        <p>Task: {{$task->parent['text']}}<p>
                        <p>Division: {{$task->parent->piu['short_name']}}</p>
                    </td>
                    <td>
                        @foreach($last_tasks as $last_task)
                          @if($task->parent_id == $last_task->parent_id)
                            <p>
                              @if($last_task->progress == 1)
                                  <i class="fas fa-check" style="color:green"></i>
                                  <?php
                                  $color = "green";
                                  ?>
                              @else
                                <i class="fas fa-times" style="color:red"></i>
                                <?php
                                $color = "red";
                                ?>
                              @endif
                              <font color = "{{$color}}">To complete {{$last_task->text}} by:{{date('d M Y', strtotime($last_task->start_date. ' + '.$last_task->duration .' day'))}} </font></p>
                            <p>Status:
                              @foreach($last_task->comments as $last_comment)
                                  @if($last_discussion->id == $last_comment->discussion_id)
                                    {{$last_comment->comment}}
                                    <?php $last_progress = $last_comment->progress; ?>
                                    <?php break; ?>
                                  @endif
                              @endforeach
                            </p>
                            <?php break; ?>
                          @endif
                        @endforeach
                    </td>
                    <td>
                        <p>To complete {{$task->text}} by: {{date('d M Y', strtotime($task->start_date. ' + '.$task->duration .' day'))}} </p>
                        <p>Status:
                            @foreach($task->comments as $comment)
                                  {{$comment->comment}}
                                  <?php break; ?>
                            @endforeach
                         </p>
                    </td>
                    <td>
                      <p>
                          On {{date('d M Y', strtotime($last_discussion->updated_at))}} : {{$last_progress*100}}%
                          <!-- <div class="progress progress-xs">

                                <div class="progress-bar progress-bar-danger" style="width: {{$last_progress*100}}%"></div>
                          </div> -->
                      </p>
                      <p>
                          On {{date('d M Y', strtotime($discussion->updated_at))}} : {{($task->parent['progress'])*100}}%
                          <!-- <div class="progress progress-xs">

                              <div class="progress-bar progress-bar-danger" style="width: {{($task->parent['progress'])*100}}%"></div>
                          </div> -->
                      </p>
                    </td>
                </tr>
                <?php $count ++; ?>
              @endforeach

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
