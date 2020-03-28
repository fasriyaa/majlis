@extends('layouts.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Timeline of:</h1>
          <p>{{$contract['contract_no']}} | {{$contract['name']}}</p>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active"><a href = "/contracts">Contracts</a></li>
            <li class="breadcrumb-item active">Timeline</li>
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
                          <td>{{date('d M Y', strtotime($timeline->updated_at))}}</td>
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



            <!-- Pending Action Table -->
            <?php $approval_count = 0;  ?>
            @if($approval_count>0)
              <div class = "col-sm-12">
                <div class="card card">
                  <div class="card-header">
                    <h3 class="card-title"><font color = "red">Pending Actions</font></a></h3>
                  </div>
                  <!-- /. card header -->

                  <div class="card-body table-responsive p-0">
                        <table class="table table-hover">

                              <tr>
                                <td>Pending Approval From: </td>
                                <td></td>
                                <td>

                                      <a href="#" class="btn btn-sm btn-warning fa fa-times" data-toggle="modal" data-target="#cancel_approval_modal" data-id = "" onclick = "$('#subtask2_id').val($(this).data('id'));"></a>

                                      <a href="#" class="btn btn-sm btn-info fa fa-check" data-toggle="modal" data-target="#approve_modal" data-id = "" onclick = "$('#subtask3_id').val($(this).data('id'));"></a>

                              </td>
                              </tr>



                            <tr>
                                <td>Document Required</td>
                                <td></td>
                                <td>

                                    <a href="#" class="btn btn-sm btn-warning fa fa-times" data-toggle="modal" data-target="#cancel_doc_modal" data-id = "" onclick = "$('#subtask5_id').val($(this).data('id'));"></a>

                                </td>
                            </tr>

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
                  <?php $col = "green"; $status = "Active contract"; ?>
                  <h3 class="card-title">Actions   <font color = "{{$col}}">[{{$status}}]</font></h3>
                </div>
                <!-- /. card header -->

                <div class="card-body table-responsive p-0">
                  <table class="table table-hover">



                    @if($contract_count < 1)
                      @can('Create Contracts')
                        <tr align = "left">
                          <td></td>
                          <td>Upload Contract <a href="" class="fa fa-hand-point-right" data-toggle="modal" data-target="#upload_contract" data-id = "" onclick = ""></a>
                          </td>
                        </tr>
                      @endcan
                    @endif
                    @can('Create Variations')
                      <tr align = "left">
                        <td></td>
                          <td onclick = "new_variation({{$contract['id']}},{{$contract['task_id']}});"> Request for Variation <a  class="fa fa-hand-point-right" id = ""></a>
                          </td>
                      </tr>
                    @endcan
                    @can('Create Contracts')
                        <tr align = "left">
                          <td></td>
                          <td> Upload contract amendment <a href="" class="fa fa-hand-point-right" data-toggle="modal" data-target="#upload_amendment" data-id = "" onclick = ""></a>
                          </td>
                        </tr>
                    @endcan
                    <tr align = "left">
                      <td></td>
                      <td>View ledger <a href="" class="fa fa-hand-point-right" data-toggle="modal" data-target="#new_comment" data-id = "" onclick = "$('#subtask1_id').val($(this).data('id'));"></a>
                      </td>
                    </tr>
                    @if($contract['task_id'] == null)
                        <tr align = "left">
                          <td></td>
                          <td>Link to a Task <a href="{{ url('/contracts/link_task', $contract['id']) }}" class="fa fa-hand-point-right"  data-target="" data-id = "" onclick = ""></a>
                          </td>
                        </tr>
                    @endif
                    <tr align = "left">
                      <td></td>
                      <td>Terminate <a href="" class="fa fa-hand-point-right" data-toggle="modal" data-target="#new_comment" data-id = "" onclick = "$('#subtask1_id').val($(this).data('id'));"></a>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
            <!-- /. left First Table -->

            <!-- Left variation table -->
            @if($contract['task_id'] != null)
                <div class = "col-sm-12">
                  <div class="card card">
                    <div class="card-header">
                      <h3 class="card-title">Variations</h3>
                    </div>
                    <!-- /. card header -->

                    <div class="card-body table-responsive p-0">
                      <table class="table table-hover">
                        <tr align = "left">
                          <th>Variation_No</th>
                          <th>Text</th>
                          <th>Status</th>
                        </tr>
                        @foreach($variations as $variation)

                            <tr>
                              <td><a href = "{{ url('/variations/timeline', $variation->id) }}">{{$variation->id}}</a></td>
                              <td>
                                @foreach($variation->timeline as $tl)
                                    @if($tl->type == 11)
                                      {{$tl->text}}
                                      <?php break; ?>
                                    @endif
                                @endforeach
                              </td>
                              <td>
                                  <?php $break = 0; ?>
                                  @if($variation->status == 0)
                                      <?php $status = "Rejcted"; $col = "Red"; ?>
                                  @endif
                                  @if($variation->status == 1)
                                      @if($break == 0 and $variation['matrix']['varification_check'] ==1 and $variation['matrix']['varification_status'] == 1)
                                        <?php $status = "Pending Varification"; $col = "orange";  $break = 1;?>
                                      @endif
                                      @if($break == 0 and  $variation['matrix']['approval_check'] ==1 and $variation['matrix']['approval_status'] == 1)
                                        <?php $status = "Pending Approval"; $col = "orange";  $break = 2;?>
                                      @endif
                                      @if($break == 0 and  $variation['matrix']['authorize_check'] ==1 and $variation['matrix']['authorize_status'] == 1)
                                        <?php $status = "Pending Authorization"; $col = "orange";  $break = 3;?>
                                      @endif
                                  @endif
                                  @if($variation->status == 2)
                                      @if($break == 0 and  $variation['matrix']['approval_check'] ==1 and $variation['matrix']['approval_status'] == 1)
                                        <?php $status = "Pending Approval"; $col = "orange";  $break = 2;?>
                                      @endif
                                      @if($break == 0 and  $variation['matrix']['authorize_check'] ==1 and $variation['matrix']['authorize_status'] == 1)
                                        <?php $status = "Pending Authorization"; $col = "orange";  $break = 3;?>
                                      @endif
                                  @endif
                                  @if($variation->status == 3)
                                      @if($break == 0 and  $variation['matrix']['authorize_check'] ==1 and $variation['matrix']['authorize_status'] == 1)
                                        <?php $status = "Pending Authorization"; $col = "orange";  $break = 3;?>
                                      @endif
                                  @endif
                                  @if($variation->status == 4)
                                      <?php $status = "Effective"; $col = "green"; ?>
                                  @endif
                                  <font color = "{{$col}}"> {{$status}} </font>
                              </td>
                            </tr>

                      @endforeach
                      </table>
                    </div>
                  </div>
                </div>
            @endif
            <!-- /. Left variation Table -->

            <!-- Left Documents Table -->
            @if($doc_count>0)
                <div class = "col-sm-12">
                  <div class="card card">
                    <div class="card-header">
                      <h3 class="card-title">Documents</h3>
                    </div>
                    <!-- /. card header -->

                    <div class="card-body table-responsive p-0">
                      <table class="table table-hover">
                        <tr align = "left">
                          <th>Document Name</th>
                          <th>Date</th>
                        </tr>
                        @foreach($docs as $doc)
                            <tr>
                              <td><a href = "{{ url('/files', $doc->doc_name) }}">{{$doc->alias_name}}</a></td>
                              <td>{{date('d F Y', strtotime($doc->doc_date))}}</td>
                            </tr>
                        @endforeach
                      </table>
                    </div>
                  </div>
                </div>
            @endif
            <!-- /. Left Documents Table -->
            <!-- Left Task Table -->
            @if($contract['task_id'] != null)
                <div class = "col-sm-12">
                  <div class="card card">
                    <div class="card-header">
                      <h3 class="card-title">Task</h3>
                    </div>
                    <!-- /. card header -->

                    <div class="card-body table-responsive p-0">
                      <table class="table table-hover">
                        <tr align = "left">
                          <th>Task Name</th>
                          <th>Progress</th>
                        </tr>

                            <tr>
                              <td><a href = "{{ url('/subtask', $contract['task']['id']) }}">{{$contract['task']['text']}}</a></td>
                              <td>{{$contract['task']['progress']*100}}%</td>
                            </tr>

                      </table>
                    </div>
                  </div>
                </div>
            @endif
            <!-- /. Left task Table -->

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

<!-- Upload file Modal -->
<div class="modal fade" id="upload_contract">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Upload Contract</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Address Modal body -->
      <div class="modal-body">
        {!! Form::open(['method' => 'POST', 'route' => ['contracts.upload'], 'files' => true,]) !!}
        @csrf
        <div class="form-group">
          <input type="hidden" name = "contract_id" value = "{{$contract['id']}}">
          <input type="hidden" name = "req_doc_type" value = "4">
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
<!-- /. upload file modal -->

<!-- link to a task -->
<div class="modal fade" id="link_task">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Link to a project task</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Address Modal body -->
      <div class="modal-body">
        {!! Form::open(['method' => 'POST', 'route' => ['contracts.link_task'], 'files' => false,]) !!}
        <div class="form-group">
          <input type="hidden" name = "contract_id" value = "{{$contract['id']}}">
          <label for="name">Select Task*</label>
          <select id = "task_id" name="task_id" class="custom-select">
            @foreach($tasks as $task)
              <option value="{{$task->id}}" >{{$task->text}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <!-- /. link to a task Modal body -->

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="submit" class="btn btn-info">Save</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

      </div>
        {!! Form::close() !!}
    </div>
  </div>
</div>
<!-- /. link to a task Modal -->
<!-- link to a task -->
<div class="modal fade" id="link_task_err">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Contract must be linked to a task before processing any variation</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Address Modal body -->
      <div class="modal-body">
        {!! Form::open(['method' => 'POST', 'route' => ['contracts.link_task'], 'files' => false,]) !!}
        <div class="form-group">
          <input type="hidden" name = "contract_id" value = "{{$contract['id']}}">
          <label for="name">Select Task*</label>
          <select id = "task_id" name="task_id" class="custom-select">
            @foreach($tasks as $task)
              <option value="{{$task->id}}" >{{$task->text}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <!-- /. link to a task Modal body -->

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="submit" class="btn btn-info">Save</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

      </div>
        {!! Form::close() !!}
    </div>
  </div>
</div>
<!-- /. link to a task Modal -->

<!-- Upload Contract amendements Modal -->
<div class="modal fade" id="upload_amendment">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Upload Contract amendment</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Address Modal body -->
      <div class="modal-body">
        {!! Form::open(['method' => 'POST', 'route' => ['amendment.upload'], 'files' => true,]) !!}
        @csrf
        <div class="form-group">
          <input type="hidden" name = "contract_id" value = "{{$contract['id']}}">
          <div class="custom-file">
            <input type="file" name = "file" class="custom-file-input" id="customFile" required>
            <label class="custom-file-label" for="customFile">Choose file</label>
          </div>
        </div>
        <div class="form-group">
          <label for="name">Contract Amendment Name</label>
          <input type = "text" name = "amendment" class = 'form-control' value = "" required>
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
<!-- /. upload contract amendment modal -->

@section('javascript')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="/dist/plugins/customfiles/custom-files.min.js"></script>

<script type="text/javascript">


    function new_variation(contract_id,task_id)
    {
      if(task_id == null)
      {
        $('#link_task_err').modal('show');
        // alert("ERROR: Contract should be linked to a Task");

      }else {
        window.location.href= '/variations/create/' + contract_id ,true;
        // alert(contract_id);
      }
      return false;
    }


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
