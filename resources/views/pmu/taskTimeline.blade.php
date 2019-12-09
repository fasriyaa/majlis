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

            <!-- Approved info table -->
            @if($approve_count>0)
            <div class = "col-sm-12">
              <div class="card card">
                <div class="card-header">
                  <h3 class="card-title"><font color = "green">Approved</font></a></h3>
                </div>
                <!-- /. card header -->

                <div class="card-body table-responsive p-0">
                      <table class="table table-hover">
                        <tr>
                          <th>User</th>
                          <th>Comment</th>
                          <th>Date</th>
                        </tr>
                        @foreach($approves as $approve)
                          <tr>
                            <td>{{$approve->user['name']}}</td>
                            <td>{{$approve->comment}}</td>
                            <td>{{$approve->created_at}}</td>
                          </tr>
                        @endforeach

                      </table>
                </div>
              </div>
            </div>
            @endif
            <!-- /. Approved info table -->

            <!-- Pending Action Table -->
            @if($approval_count>0)
              <div class = "col-sm-12">
                <div class="card card">
                  <div class="card-header">
                    <h3 class="card-title">Pending Actions</a></h3>
                  </div>
                  <!-- /. card header -->

                  <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                          @foreach($approvals as $approval)
                              <tr>
                                <td>Pending Approval From: </td>
                                <td>{{$approval->user['name']}}</td>
                                <td>
                                    @if($approval->user_id==$user_id)
                                      <a href="#" class="btn btn-sm btn-warning fa fa-times" data-toggle="modal" data-target="#cancel_approval_modal" data-id = "{{$approval->id}}" onclick = "$('#subtask2_id').val($(this).data('id'));"></a>
                                    @endif
                                    @if($approval->user['id']==$user_id)
                                      <a href="#" class="btn btn-sm btn-info fa fa-check" data-toggle="modal" data-target="#approve_modal" data-id = "{{$approval->id}}" onclick = "$('#subtask3_id').val($(this).data('id'));"></a>
                                    @endif
                              </td>
                              </tr>
                          @endforeach
                        </table>
                  </div>
                </div>
              </div>
            @endif
            <!-- /. Pending Action Table -->

            <!-- first Table -->
            <div class = "col-sm-12">
              <div class="card card">
                <div class="card-header">
                  <h3 class="card-title">Task Actions</a></h3>
                </div>
                <!-- /. card header -->

                <div class="card-body table-responsive p-0">
                  <table class="table table-hover">
                    @if($task_name['progress'] < 1)
                    <tr id = "{{$task_name['id']}}" align = "left" onclick = "update_progress(this);">
                      <td></td>
                      <td>Mark as Complete <a href="" class="fa fa-hand-point-right"></a>
                      </td>
                    </tr>
                    @endif
                    <tr align = "left">
                      <td></td>
                      <td>{{$task_name['user']['name']}} <a href="" class="fa fa-hand-point-right" data-toggle="modal" data-target="#assign_staff_modal" data-id = "{{$task_name['id']}}" onclick = "$('#subtask_id').val($(this).data('id'));"></a>
                      </td>
                    </tr>
                    <tr align = "left">
                      <td></td>
                      <td>Upload Document <a href="" class="fa fa-hand-point-right" data-toggle="modal" data-target="#assign_staff_modal" data-id = "{{$task_name['id']}}" onclick = "$('#subtask_id').val($(this).data('id'));"></a>
                      </td>
                    </tr>
                    <tr align = "left">
                      <td></td>
                      <td> Require Approval <a href="" class="fa fa-hand-point-right" data-toggle="modal" data-target="#assign_approval_modal" data-id = "{{$task_name['id']}}" onclick = "$('#subtask1_id').val($(this).data('id'));"></a>
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

<!-- Assign Approval Staff -->
<div class="modal fade" id="assign_approval_modal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Assign Approval Staff</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Address Modal body -->
      <div class="modal-body">
        {!! Form::open(['method' => 'POST',  'files' => false,]) !!}
        <div class="form-group">
          <input type="hidden" name = "subtask1_id" id = "subtask1_id">
          <label for="name">Select Staff*</label>
          <select id = "approval_staff" name="approval_staff" class="custom-select">
            @foreach($users as $user)
              <option value="{{$user->id}}" >{{$user->name}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <!-- /. Address Modal body -->

      <!-- Modal footer -->
      <div class="modal-footer">
        <button id = "approve_staff" type="submit" class="btn btn-info" data-dismiss="modal">Save</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

      </div>
        {!! Form::close() !!}
    </div>
  </div>
</div>
<!-- /. Assign Staff Modal -->

<!-- Approval Cancel Modal -->
<div class="modal fade" id="cancel_approval_modal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Cancel Approval</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Address Modal body -->
      <div class="modal-body">
        {!! Form::open(['method' => 'POST',  'files' => false,]) !!}
        <div class="form-group">
          <input type="hidden" name = "subtask2_id" id = "subtask2_id">
          <label for="name">Are You Sure you want to cancel approval?</label>
        </div>
      </div>
      <!-- /. Address Modal body -->

      <!-- Modal footer -->
      <div class="modal-footer">
        <button id = "cancel_approval" type="submit" class="btn btn-info" data-dismiss="modal">Yes</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>

      </div>
        {!! Form::close() !!}
    </div>
  </div>
</div>
<!-- /. Approval Cancel modal -->

<!-- Approve Modal -->
<div class="modal fade" id="approve_modal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Approve! Are you sure?</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Address Modal body -->
      <div class="modal-body">
        {!! Form::open(['method' => 'POST',  'files' => false,]) !!}
        <div class="form-group">
          <input type="hidden" name = "subtask3_id" id = "subtask3_id">
          <label for="comment_label">comment*</label>
          <textarea id = "approve_comment" class="form-control" rows="3" placeholder="Comment ..."></textarea>
        </div>
      </div>
      <!-- /. Address Modal body -->

      <!-- Modal footer -->
      <div class="modal-footer">
        <button id = "approve" type="submit" class="btn btn-info" data-dismiss="modal">Yes</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>

      </div>
        {!! Form::close() !!}
    </div>
  </div>
</div>
<!-- /. Approve modal -->

@section('javascript')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script type="text/javascript">

// Loading script

//end loading script

function update_progress(object)
{
    var progress = 1;
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

// Start assigned staff Store
$("#approve_staff").click(function() {
  var staff_id = $('#approval_staff').val();
  var subtask_id = $('#subtask1_id').val();
  if(staff_id){
        $.ajax({
           type:"get",
           url:"{{url('/assign_approval_staff')}}/"+subtask_id+"/"+staff_id,
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

//Cancel Approval Staff
$("#cancel_approval").click(function() {
  var approval_id = $('#subtask2_id').val();
  if(approval_id){
        $.ajax({
           type:"get",
           url:"{{url('/cancel_approval')}}/"+approval_id,
           success:function(res)
           {
                if(res==0)
                {
                    alert("User don't have permission");
                }else {
                    location.reload();
                }
           }

        });
  }

});

//Cancel Approval Staff
$("#approve").click(function() {
  var approval_id = $('#subtask3_id').val();
  var comment = $('#approve_comment').val();

  if(comment){
    $.ajax({
       type:"get",
       url:"{{url('/approve')}}/"+approval_id+"/"+comment,
       success:function(res)
       {
            if(res==0)
            {
                alert("User don't have permission");
            }else {
                location.reload();
            }
       }

    });

  }else {
    alert("Comment is Required");
  }

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
@stop
