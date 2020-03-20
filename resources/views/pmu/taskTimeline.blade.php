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
            <li class="breadcrumb-item active"><a href = "/subtask/{{$task_name['parent']}}">Sub Activities</a></li>
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
            @if($approval_count>0 or $req_docs_count>0)
              <div class = "col-sm-12">
                <div class="card card">
                  <div class="card-header">
                    <h3 class="card-title"><font color = "red">Pending Actions</font></a></h3>
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

                          @foreach($req_docs as $req_doc)
                            <tr>
                                <td>Document Required</td>
                                <td>{{$task_name['user']['name']}}</td>
                                <td>
                                  @if($task_name['user']['id']==$user_id)
                                    <a href="#" class="btn btn-sm btn-warning fa fa-times" data-toggle="modal" data-target="#cancel_doc_modal" data-id = "{{$req_doc->id}}" onclick = "$('#subtask5_id').val($(this).data('id'));"></a>
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

            <!-- first Table Task Actions -->
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
                      <td>Upload Document <a href="" class="fa fa-hand-point-right" data-toggle="modal" data-target="#upload_doc_modal" data-id = "{{$task_name['id']}}" onclick = "$('#subtask6_id').val($(this).data('id'));"></a>
                      </td>
                    </tr>
                    <tr align = "left">
                      <td></td>
                      <td> Require Approval <a href="" class="fa fa-hand-point-right" data-toggle="modal" data-target="#assign_approval_modal" data-id = "{{$task_name['id']}}" onclick = "$('#subtask1_id').val($(this).data('id'));"></a>
                      </td>
                    </tr>
                    <tr align = "left">
                      <td></td>
                      <td> Require Document <a href="" class="fa fa-hand-point-right" id = "{{$task_name['id']}}" onclick = "require_doc(this);"></a>
                      </td>
                    </tr>
                    <tr align = "left">
                      <td></td>
                      <td> Insert a comment <a href="" class="fa fa-hand-point-right" data-toggle="modal" data-target="#new_comment" data-id = "{{$task_name['id']}}" onclick = "$('#subtask1_id').val($(this).data('id'));"></a>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
            <!-- /. left First Table -->
            <!-- Left Documents Table -->
            @if($documents_count>0)
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
                          <th></th>
                        </tr>
                        @foreach($documents as $document)
                            <tr>
                              <td><a href = "{{ url('/files', $document->doc_name) }}">{{$document->doc_name}}</a></td>
                              <td>{{$document->updated_at}}</td>
                              <td></td>
                            </tr>
                        @endforeach
                      </table>
                    </div>
                  </div>
                </div>
            @endif
            <!-- /. Left Documents Table -->
            <!-- Left Comments Table -->
            <div class = "col-sm-12">

            </div>
            <!-- /. Left Comments Table -->
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

<!-- Cancel Doc Modal -->
<div class="modal fade" id="cancel_doc_modal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Cancel Document Required</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Address Modal body -->
      <div class="modal-body">
        {!! Form::open(['method' => 'POST',  'files' => false,]) !!}
        <div class="form-group">
          <input type="hidden" name = "subtask5_id" id = "subtask5_id">
          <label for="name">Are You Sure you want to cancel Document Required?</label>
        </div>
      </div>
      <!-- /. Address Modal body -->

      <!-- Modal footer -->
      <div class="modal-footer">
        <button id = "cancel_doc" type="submit" class="btn btn-info" data-dismiss="modal">Yes</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>

      </div>
        {!! Form::close() !!}
    </div>
  </div>
</div>
<!-- /. Cancel Doc Modal -->

<!-- Upload file Modal -->
<!-- Assign Staff Modal -->
<div class="modal fade" id="upload_doc_modal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Upload Document</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Address Modal body -->
      <div class="modal-body">
        {!! Form::open(['method' => 'POST', 'route' => ['pmu.upload_doc'], 'files' => true,]) !!}
        @csrf
        <div class="form-group">
          <input type="hidden" name = "subtask6_id" id = "subtask6_id">
          <div class="custom-file">
            <input type="file" name = "file" class="custom-file-input" id="customFile">
            <label class="custom-file-label" for="customFile">Choose file</label>
          </div>
        </div>
      </div>
      <!-- /. Address Modal body -->

      <!-- Modal footer -->
      <div class="modal-footer">
        <button id = "upload_doc" type="submit" class="btn btn-info">Upload</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

      </div>
        {!! Form::close() !!}
    </div>
  </div>
</div>
<!-- /. Assign Staff Modal -->
<!-- /. upload file modal -->

<!-- Review line items modal -->
<div class="modal fade" id="new_comment">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Comment</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Address Modal body -->
      <div class="modal-body">
        {!! Form::open(['method' => 'POST', 'route' => ['new.comment'], 'files' => false,]) !!}
        <input type="hidden" name = "task_id" id = "task_id" value = "{{$task_name['id']}}">
        <input type="hidden" name = "discussion_id" id = "discussion_id" value = "0">
        <input type="hidden" name = "_token" value="{{ csrf_token() }}">
        <div class="form-group">
          <p>Task: {{$task_name['text']}}</p>
          <p>Assigned To: {{$task_name['user']['name']}}</p>
          <label for="status">Current Status</label>

          <textarea id = "status" name = "status" class="form-control" rows="3" value = "">{{$comments['comment']}} - {{date("d F Y", strtotime($comments['updated_at']))}}</textarea>
          <br>
          <label for="next_step">Next Step</label>
          <textarea id = "next_step" name = "next_step" class="form-control" rows="3">{{$comments['next_step']}}</textarea>
          <br>

        </div>
      </div>
      <!-- /. Address Modal body -->

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="submit" class="btn btn-info">Save</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
      {!! Form::close() !!}
    </div>
  </div>
</div>
<!-- /. Review line items modal -->

@section('javascript')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="/dist/plugins/customfiles/custom-files.min.js"></script>

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


//Setting the required doc
function require_doc(object)
{
    var task_id = object.id;

    if(task_id){
          $.ajax({
             type:"get",
             url:"{{url('/require_doc')}}/"+task_id,
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

//Cancel Doc Required
$("#cancel_doc").click(function() {
  var doc_id = $('#subtask5_id').val();
  if(doc_id){
        $.ajax({
           type:"get",
           url:"{{url('/cancel_doc')}}/"+doc_id,
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

//view of selected upload file
$(document).ready(function () {
  bsCustomFileInput.init();
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
