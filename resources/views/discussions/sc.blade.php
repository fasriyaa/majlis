@extends('layouts.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Meeting | {{date('d F Y', strtotime($discussion['meeting_date']))}}</h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Discussions</li>
            <li class="breadcrumb-item active">Steering Committee</li>
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

<br>
<div class = "row">
<!-- Agenda -->
      <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Agenda</h3>


              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table">
                  <thead>
                    <tr align = "left">
                      <th style="width: 10px">#</th>
                      <th>Item</th>
                      <th>Submitted by:</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $count = 1; ?>
                    @foreach($agendas as $agenda)
                        <tr>
                          <td>{{$count}}</td>
                          <td>{{$agenda->description}}</td>
                          <td>
                            @if($agenda->submitter_type == 1)
                              {{$agenda->piu['short_name']}}
                            @else
                              {{$agenda->user['name']}}
                            @endif
                          </td>
                        </tr>
                        <?php $count++; ?>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                @if($discussion['status']==1)
                  <a href = "" data-toggle="modal" data-target="#new_agenda"><button class="btn btn-info float-right">Add</button></a>
                @endif
              </div>


            </div>
            <!-- /.card -->

          </div>
          <!-- /. col -->

          <!-- Documents -->
                <div class="col-md-6">

                      <!-- / Actions Table -->
                        <div class="card card">
                          <div class="card-header">
                            <?php if($discussion['status'] == 1)
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

                                  @if($discussion['status'] == 1)
                                      <tr>
                                        <td data-toggle="modal" data-target="#add_participants">Add Participants </td>
                                      </tr>
                                  @endif

                                  @if($discussion['status'] == 1)
                                      <tr>
                                        <td data-toggle="modal" data-target="#upload_min" data-id = "{{$discussion['id']}}" onclick = "$('#disucssion1_id').val($(this).data('id'));">Upload Minutes </td>
                                      </tr>
                                  @endif
                                  @if($discussion['status'] == 1)
                                      <tr>
                                        <td data-toggle="modal" data-target="#close_discussion">Close Meeting </td>
                                      </tr>
                                  @endif


                                </table>
                          </div>
                        </div>
                      </dvi>
                  <!-- /. Action Table -->

                    <!-- Documents -->
                      <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Reference Documents</h3>


                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                          <table class="table table-striped">
                            <thead>
                              <tr align = "left">
                                <th style="width: 10px">#</th>
                                <th>Document Name</th>
                                <th>Document Date:</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php $count = 1; ?>
                              @foreach($docs as $doc)
                                <tr>
                                  <td>{{$count}}</td>
                                  <td><a href = "{{ url('/files', $doc->doc_name) }}">{{$doc->alias_name}}</a></td>
                                  <td>
                                    @if($doc->doc_date == null)
                                      NA
                                    @else
                                      {{date("d F Y", strtotime($doc->doc_date))}}
                                    @endif
                                  </td>
                                </tr>
                                <?php $count++; ?>
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            @if($discussion['status'] == 1)
                              <a href = "" data-toggle="modal" data-target="#upload_doc_modal" data-id = "{{$discussion['id']}}" onclick = "$('#subtask6_id').val($(this).data('id'));"><button type="" class="btn btn-info float-right">Upload</button></a>
                            @endif
                        </div>
                      </div>
                      <!-- /.card -->

                      <!-- Meeting Minutes -->
                      <div class="card">
                        <!-- <div class="card-header">
                          <h3 class="card-title">Meeting Minutes: <a href = "#"> </a></h3>
                        </div> -->
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                              <table class="table table-hover">
                                @if(empty($mins))
                                <tr>
                                  <td>Meeting Minutes: <font color = "red">Not Available</font></td>
                                </tr>
                                @else
                                  @foreach($mins as $min)
                                    <tr>
                                      <td>Meeting Minutes: <a href = "">{{$min->doc_name}}</a></td>
                                    </tr>
                                  @endforeach
                                @endif
                              </table>
                        </div>

                        <!-- /.card-body -->
                      </div>
                      <!-- /.card -->
                      <!-- /. Meeting Minutes -->

                      <!-- Meeting Minutes -->
                      <div class="card card">
                        <div class="card-header">
                          <h3 class="card-title">Participants</a></h3>
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
                      <!-- /.card -->
                      <!-- /. Meeting Minutes -->





                    </div>
                    <!-- /. col -->



      </div>
      <!-- /. row -->

    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

<!-- Create New agenda item -->
<div class="modal fade" id="new_agenda">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add Agenda Item</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Address Modal body -->
      <div class="modal-body">
        {!! Form::open(['method' => 'POST', 'route' => ['agenda.store'], 'files' => false,]) !!}
        <input type="hidden" name = "discussion_id" id = "discussion_id" value = "{{$discussion['id']}}">
        <input type="hidden" name = "_token" value="{{ csrf_token() }}">
        <div class="form-group">
          <label for="name">Select Group*</label>
          <select id = "submitter_type" name="submitter_type" class="custom-select" onChange="getSubmitter(this.value);">
              <option value="1" >PIU</option>
              <option value="2" >Users</option>
          </select>
        </div>
        <div class="form-group">
          <label for="name">Select Submited By*</label>
          <select id = "submitter_id" name="submitter_id" class="custom-select">
            @foreach($pius as $piu)
              <option value="{{$piu->id}}" >{{$piu->short_name}}</option>
            @endforeach
          </select>

        </div>
        <div class="form-group">
          <label for="name">Enter Description*</label>
          <input type="text" name = "description" id = "description" class="form-control">
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
<!-- /. Create new agenda item -->

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
          <input type="hidden" name = "discussion_id" id = "discussion_id" value = "{{$discussion['id']}}">
          <input type="hidden" name = "discussion_type" id = "discussion_type" value = "{{$discussion['type']}}">
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

<!-- Upload file Modal -->
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
          <input type="hidden" name = "req_doc_type" id = "req_doc_type" value = "2">
          <div class="custom-file">
            <input type="file" name = "file" class="custom-file-input" id="customFile">
            <label class="custom-file-label" for="customFile">Choose file</label>
          </div>
        </div>
        <div class="form-group">
          <label for="name">Enter Document Name*</label>
          <input type="text" name = "alias_name" id = "alias_name" class="form-control">
        </div>
        <div class="form-group">
          <label for="name">Select Date of Document*</label>
          <input type = "text" id = "datepicker" class = "form-control" name = "doc_date" value = "">
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

<!-- Upload Miniutes -->
<div class="modal fade" id="upload_min">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Upload Minutes</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Address Modal body -->
      <div class="modal-body">
        {!! Form::open(['method' => 'POST', 'route' => ['pmu.upload_doc'], 'files' => true,]) !!}
        @csrf
        <div class="form-group">
          <input type="hidden" name = "subtask6_id" id = "disucssion1_id">
          <input type="hidden" name = "req_doc_type" id = "req_doc_type" value = "3">
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
<!-- /. upload Minutes modal -->

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
          <input type="hidden" name = "discussion_id" id = "discussion_id" value = "{{$discussion['id']}}">
          <input type="hidden" name = "discussion_type" id = "discussion_type" value = "{{$discussion['type']}}">
          <input type="hidden" name = "_token" value="{{ csrf_token() }}">
          <p> Are you sure you want to close the discussoin?</p>
        </div>
      </div>
      <!-- /. Address Modal body -->

      <!-- Modal footer -->
      <div class="modal-footer">
        <button id = "save_participants" type="submit" class="btn btn-info">Save</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>

      </div>
        {!! Form::close() !!}
    </div>
  </div>
</div>
<!-- /. close discussion modal -->

@section('javascript')
<!-- jQuery -->
<script src="/dist/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script src="/dist/plugins/customfiles/custom-files.min.js"></script>

<script>
  $.widget.bridge('uibutton', $.ui.button)

  $(document).ready(function () {
      $('#datepicker').datepicker({
        uiLibrary: 'bootstrap'
      });
  });

  //view of selected upload file
  $(document).ready(function () {
    bsCustomFileInput.init();
  });

</script>
<style>
    .datepicker {
      z-index: 1600 !important; /* has to be larger than 1050 */
    }
</style>
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

<script>
function getSubmitter(val)
{
          $('#submitter_id').empty();
            if(val == 1)
              {
                <?php  foreach($pius as $piu) { ?>
                  $('#submitter_id').append($('<option></option>').val({{$piu->id}}).html('{{$piu->short_name}}'));
                <?php  } ?>
              }else {
                <?php  foreach($users as $user) { ?>
                  $('#submitter_id').append($('<option></option>').val({{$user->id}}).html('{{$user->name}}'));
                <?php  } ?>
              }
}
</script>

@stop
