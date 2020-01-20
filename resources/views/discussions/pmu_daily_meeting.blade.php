@extends('layouts.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">PMU Daily Meetings</h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Discussions</li>
            <li class="breadcrumb-item active">PMU Daily Meetings</li>
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

        <div class="col-7">
          <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">Cruid List</h3>

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
                  <th>Task</th>
                  <th>Actions</th>
                </tr>

                <?php $count = 0; ?>
                @foreach($subtasks as $subtask)
                    @if($subtask->status == 1)
                        <?php $count = $count+1; ?>
                        <tr id = "1" onclick = "#">
                          <td>{{$count}}</td>
                          <td>{{$subtask->task['text']}}</td>
                          <td field-key='action'>
                            <a href="#" class="fa fa-eye"></a>
                          </td>
                        </tr>
                    @endif
                @endforeach




              </table>
            </div>
            <!-- /.card-body -->
            <!-- Card Footer -->
            <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                  <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                  <li class="page-item"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                </ul>
            </div>
            <!-- /. Card footer -->
          </div>
          <!-- /.card -->

          <!-- Reviewed list -->
          <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">Reviewed Items</h3>

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
                  <th>ID</th>
                  <th>Task</th>
                  <th>Status</th>
                  <th>Next Step</th>
                </tr>

                @foreach($subtasks as $subtask)
                    @if($subtask->status == 2)
                        <?php $count = $count+1; ?>
                          <tr id = "1" onclick = "location.href='/pmu_daily_meeting/'+this.id;">
                            <td>1</td>
                            <td>{{$subtask->task['text']}}</td>
                            <td>
                              <p>{{$subtask->comment}}<p>
                            </td>
                            <td>{{$subtask->next_step}}</td>
                          </tr>
                    @endif
                @endforeach




              </table>
            </div>
            <!-- /.card-body -->
            <!-- Card Footer -->
            <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                  <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                  <li class="page-item"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                </ul>
            </div>
            <!-- /. Card footer -->
          </div>
          <!-- /.Reviewed list -->

        </div>
        <!-- /. Left col -->

        <!-- Right Col -->
        <div class = "col-sm-5">
          <div class = "col-sm-12">
            <div class="card card">
              <div class="card-header">
                <?php if($discussion_status['status'] == 1)
                      {
                          $color = "green";
                          $text = "[Open]";
                      }else
                        {
                          $color = "red";
                          $text = "[Closed]";
                        } ?>

                <h3 class="card-title">Actions <font color = "{{$color}}">{{$text}} </font></h3>
              </div>
              <!-- /. card header -->

              <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                      @if($discussion_status['status'] == 1)
                          <tr>
                            <td data-toggle="modal" data-target="#add_participants">Add Participants </td>
                          </tr>
                      @endif
                      @if($discussion_status['status'] == 1)
                        @if(isset($next_item->item_id))
                              <tr>
                                <td data-toggle="modal" data-target="#review_task">Next Item </td>
                              </tr>
                        @endif
                      @endif
                      @if($discussion_status['status'] == 1)
                          <tr>
                            <td>Upload a Document </td>
                          </tr>
                      @endif
                      @if($discussion_status['status'] == 1)
                          <tr>
                            <td data-toggle="modal" data-target="#close_discussion">Close Meeting </td>
                          </tr>
                      @endif


                    </table>
              </div>
            </div>
          </dvi>
        </div>

        <div class = "col-sm-12">
          <div class="card card">
            <div class="card-header">
              <h3 class="card-title">Documents</a></h3>
            </div>
            <!-- /. card header -->

            <div class="card-body table-responsive p-0">
                  <table class="table table-hover">
                    @foreach($docs as $doc)
                    <tr>
                      <td><a href = "{{ url('/files', $doc->doc_name) }}">{{$doc->doc_name}}</a></td>
                    </tr>
                    @endforeach
                  </table>
            </div>
          </div>
        </dvi>
      </div>

      <div class = "col-sm-12">
        <div class="card card">
          <div class="card-header">
            <h3 class="card-title">Participatns</a></h3>
          </div>
          <!-- /. card header -->

          <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  @foreach($participants as $participant)
                      <tr>
                        <td>{{$participant->user['name']}}</td>
                      </tr>
                  @endforeach
                </table>
          </div>
        </div>
      </dvi>
    </div>
        <!-- /. Right col -->

      </div>
      <!-- /.row (main row) -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Review line items modal -->
<div class="modal fade" id="review_task">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Review</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Address Modal body -->
      <div class="modal-body">
        {!! Form::open(['method' => 'POST', 'route' => ['pmu.review'], 'files' => false,]) !!}
        <input type="hidden" name = "id" id = "id" value = "{{$next_item->item_id ?? ''}}">
        <input type="hidden" name = "discussion_id" id = "discussion_id" value = "{{$discussion_status['id']}}">
        <input type="hidden" name = "_token" value="{{ csrf_token() }}">
        <div class="form-group">
          <p>Task: {{$next_item->task['text'] ?? ''}}</p>
          <p>Assigned To: {{$assinged_staff->name ?? ''}}</p>
          <label for="status">Current Status</label>
          <textarea id = "status" name = "status" class="form-control" rows="3" value = ""></textarea>
          <br>
          <label for="next_step">Next Step</label>
          <textarea id = "next_step" name = "next_step" class="form-control" rows="3"></textarea>
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

<!-- Add participants modal -->
<div class="modal fade" id="add_participants">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add Participants</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Address Modal body -->
      <div class="modal-body">
        {!! Form::open(['method' => 'POST', 'route' => ['add.participants'], 'files' => false,]) !!}
        <div class="form-group">
          <input type="hidden" name = "discussion_id" id = "discussion_id" value = "{{$discussion_status['id']}}">
          <input type="hidden" name = "_token" value="{{ csrf_token() }}">
          <label for="name">Select Staff*</label>
          <select id = "user_id" name="user_id" class="custom-select">
            @foreach($users as $user)
              <option value="{{$user->id}}" >{{$user->name}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <!-- /. Address Modal body -->

      <!-- Modal footer -->
      <div class="modal-footer">
        <button id = "save_participants" type="submit" class="btn btn-info">Save</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

      </div>
        {!! Form::close() !!}
    </div>
  </div>
</div>
<!-- /. add participants modal -->

<!-- Close discussion modal -->
<div class="modal fade" id="close_discussion">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Close Discussion</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Address Modal body -->
      <div class="modal-body">
        {!! Form::open(['method' => 'POST', 'route' => ['close.discussion'], 'files' => false,]) !!}
        <div class="form-group">
          <input type="hidden" name = "discussion_id" id = "discussion_id" value = "{{$discussion_status['id']}}">
          <input type="hidden" name = "_token" value="{{ csrf_token() }}">
          <p> Are you sure you want to close the discussoin?</p>
        </div>
      </div>
      <!-- /. Address Modal body -->

      <!-- Modal footer -->
      <div class="modal-footer">
        <button id = "save_participants" type="submit" class="btn btn-info">Save</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

      </div>
        {!! Form::close() !!}
    </div>
  </div>
</div>
<!-- /. close discussion modal -->



@endsection

@section('javascript')

<script type="text/javascript">


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
