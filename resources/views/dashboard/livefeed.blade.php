@extends('layouts.master')
@section('content')
<?php
// Time Difference funciont

function time_difference($updated_at)
  {
    $str = strtotime($updated_at);
    $today = strtotime(date('Y-m-d H:i:s'));

    // It returns the time difference in Seconds...
    $time_differnce = $today-$str;

    // To Calculate the time difference in Years...
    $years = 60*60*24*365;

    // To Calculate the time difference in Months...
    $months = 60*60*24*30;

    // To Calculate the time difference in Days...
    $days = 60*60*24;

    // To Calculate the time difference in Hours...
    $hours = 60*60;

    // To Calculate the time difference in Minutes...
    $minutes = 60;

    if(intval($time_differnce/$years) > 1)
    {
        return  intval($time_differnce/$years)." years ago";
    }else if(intval($time_differnce/$years) > 0)
    {
        return  intval($time_differnce/$years)." year ago";
    }else if(intval($time_differnce/$months) > 1)
    {
        return  intval($time_differnce/$months)." months ago";
    }else if(intval(($time_differnce/$months)) > 0)
    {
        return  intval(($time_differnce/$months))." month ago";
    }else if(intval(($time_differnce/$days)) > 1)
    {
        return  intval(($time_differnce/$days))." days ago";
    }else if (intval(($time_differnce/$days)) > 0)
    {
        return  intval(($time_differnce/$days))." day ago";
    }else if (intval(($time_differnce/$hours)) > 1)
    {
        return  intval(($time_differnce/$hours))." hours ago";
    }else if (intval(($time_differnce/$hours)) > 0)
    {
        return  intval(($time_differnce/$hours))." hour ago";
    }else if (intval(($time_differnce/$minutes)) > 1)
    {
        return  intval(($time_differnce/$minutes))." minutes ago";
    }else if (intval(($time_differnce/$minutes)) > 0)
    {
        return  intval(($time_differnce/$minutes))." minute ago";
    }else if (intval(($time_differnce)) > 1)
    {
        return  intval(($time_differnce))." seconds ago";
    }else
    {
        return  "few seconds ago";
    }
  }
 ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Live Feed</h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Live Feed</li>
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

      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-7 connectedSortable">

          <!-- Post a status -->
          <div class="card direct-chat direct-chat-primary">
            <div class="card-body">
              <!-- Conversations are loaded here -->
              <form action="#" method="post">
                <div class="input-group">
                  <input type="text" name="message" placeholder="What's on your mind ..." class="form-control">
                  <span class="input-group-append">
                    <button type="button" class="btn btn-primary">Post</button>
                  </span>
                </div>
              </form>
            </div>
            <!-- /.card-body -->
          </div>
          <!--/.post status -->

          <!-- Posts -->
          @foreach($feeds as $feed)
          <div class = "card">
              <div class = "card-body">
                <div class = "row">
                    <div class = "col-sm-1">
                      <img class="direct-chat-img" src="/img/avatar5.png" alt="message user image">
                    </div>
                    <div class = "col-sm-9">
                        <p>{{$feed->user['name']}}</p>
                    </div>
                    <div class = "col-sm-2">
                      <?php
                        //Getting Feed time

                        $feed_time = time_difference($feed->updated_at);

                        // End Feed time

                      ?>
                      <p>{{$feed_time}}</p>
                    </div>
                </div>
                <div class = "row">
                  @if($feed->type == 3)
                    <p>{{$feed->text}} #Task: {{$feed->task['text']}}</p>
                  @else
                    <p>{{$feed->text}} #Task: <a href = "/to_task_timelie/{{$feed->task_id}}">{{$feed->task['text']}}</a></p>
                  @endif
                </div>



              </div>
              <div class = "card-footer">
              </div>
          </div>
          @endforeach
          <!--/.posts -->






        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-5 connectedSortable">


          <!-- TO DO List -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                <i class="ion ion-clipboard mr-1"></i> To Do List
              </h3>

              <div class="card-tools">
                <ul class="pagination pagination-sm">
                  <li class="page-item"><a href="#" class="page-link">&laquo;</a></li>
                  <li class="page-item"><a href="#" class="page-link">1</a></li>
                  <li class="page-item"><a href="#" class="page-link">2</a></li>
                  <li class="page-item"><a href="#" class="page-link">3</a></li>
                  <li class="page-item"><a href="#" class="page-link">&raquo;</a></li>
                </ul>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <ul class="todo-list">

                <!-- generating pending list -->
                @foreach($subtasks as $subtask)

                    @foreach($tasks as $task)
                      @if($task->id == $subtask->parent)
                        <?php $parent = $task->text; ?>
                      @endif
                    @endforeach
                      <li>
                        <!-- drag handle -->
                        <span class="handle">
                          <i class="fa fa-ellipsis-v"></i>
                          <i class="fa fa-ellipsis-v"></i>
                        </span>
                        <!-- checkbox -->
                        <input type="checkbox" value="" name="" id="{{$subtask->id}}" onclick="update_progress(this);">
                        <!-- todo text -->
                        <span class="text">{{$subtask->text}} | {{$parent}}</span>
                        <!-- Emphasis label -->

                        <!-- General tools such as edit or delete-->
                        <div class="tools">
                          <i class="fa fa-edit"></i>
                          <i class="fa fa-trash-o"></i>
                        </div>
                      </li>
                @endforeach

                @foreach($pending_approvals as $pending_approval)
                    <li>
                      <!-- drag handle -->
                      <span class="handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                      <!-- checkbox -->
                      <input type="checkbox" value="" name="" id="{{$pending_approval->task_id}}" onclick="update_progress(this);">
                      <!-- todo text -->
                      <span class="text">Pending Approval for: {{$pending_approval->task['text']}}</span>
                      <!-- Emphasis label -->

                      <!-- General tools such as edit or delete-->
                      <div class="tools">
                        <i class="fa fa-edit"></i>
                        <i class="fa fa-trash-o"></i>
                      </div>
                    </li>
                @endforeach

                @foreach($pending_docs as $pending_doc)
                    <li>
                      <!-- drag handle -->
                      <span class="handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                      <!-- checkbox -->
                      <input type="checkbox" value="" name="" id="{{{$pending_doc->id}}}}" onclick="update_progress(this);">
                      <!-- todo text -->
                      <span class="text">Pending Document for: {{$pending_doc->text}}</span>
                      <!-- Emphasis label -->

                      <!-- General tools such as edit or delete-->
                      <div class="tools">
                        <i class="fa fa-edit"></i>
                        <i class="fa fa-trash-o"></i>
                      </div>
                    </li>
                @endforeach
                <!-- /.pending list -->





              </ul>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
              <button type="button" class="btn btn-info float-right"><i class="fa fa-plus"></i> Add item</button>
            </div>
          </div>
          <!-- /.card -->


        </section>
        <!-- right col -->
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

<script type="text/javascript">

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
