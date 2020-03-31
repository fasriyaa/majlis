@extends('layouts.master')
@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">User Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  @if($user['profile_pic']==null)
                  <img class="profile-user-img img-fluid img-circle"
                       src="../img/avatar5.png"
                       alt="User profile picture">
                  @else
                    <img class="profile-user-img img-fluid img-circle"
                         src="{{$user['profile_pic']}}"
                         alt="User profile picture">
                  @endif

                </div>

                <h3 class="profile-username text-center">{{$user['name']}}</h3>

                <p class="text-muted text-center">{{$user['email']}}</p>

                <a href="" class="btn btn-primary btn-block" data-toggle="modal" data-target="#profile_pic"><b>Change Profile Picture</b></a>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            @if(Session::has('message'))
                <p class="alert alert-{{Session::get('label')}}">{{ Session::get('message') }}</p>
            @endif
                <!-- <a href="" class="btn btn-default btn-block" data-toggle="modal" data-target="#profile_pic"><b>Change Password</b></a> -->


          </div>
          <!-- /.col -->




          <div class="col-md-9">
            <div class="card card-primary card-outline">
              <div class="card-header p-2">
                <ul class="nav">
                  <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">User Information</a></li>
                  <li class="nav-item"><a class="nav-link" href="#edit" data-toggle="tab">Edit</a></li>
                  <li class="nav-item"><a class="nav-link" href="#change_password" data-toggle="tab">Change Password</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="settings">
                    <form class="form-horizontal">
                      <div class="form-group row">
                        <label for="organization" class="col-sm-2 col-form-label">Organization</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="organization" placeholder="" value = "{{$user['organization']}}" disabled>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="organization" class="col-sm-2 col-form-label">Department</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="department" placeholder="" value = "{{$user['piu']['short_name']}}" disabled>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="designation" class="col-sm-2 col-form-label">Designation</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="designation" placeholder="" value = "{{$user['designation']}}" disabled>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="edit">
                    <!-- <form class="form-horizontal"> -->
                    {!! Form::open(['method' => 'POST', 'route' => ['profile.update'], 'files' => false,]) !!}
                    @csrf
                      <div class="form-group row">
                        <label for="organization" class="col-sm-2 col-form-label">Organization</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name = "organization" id="organization" placeholder="" value = "{{$user['organization']}}">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="organization" class="col-sm-2 col-form-label">Department</label>
                        <div class="col-sm-10">
                          <select id = "department" name="department" class="custom-select">
                            @foreach($pius as $piu)
                              <option value="{{$piu->id}}" <?php if($user['piu']['short_name']== $piu->short_name){echo "selected";} ?> >{{$piu->short_name}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="designation" class="col-sm-2 col-form-label">Designation</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name = "designation" id="designation" placeholder="" value = "{{$user['designation']}}">
                        </div>
                      </div>


                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-danger">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- Change password -->
                  <div class="tab-pane" id="change_password">
                    <!-- <form class="form-horizontal"> -->
                    {!! Form::open(['method' => 'POST', 'route' => ['profile.change_password'], 'files' => false,]) !!}
                    @csrf
                      <div class="form-group row">
                        <label for="organization" class="col-sm-3 col-form-label">Current Password</label>
                        <div class="col-sm-9">
                          <input type="password" class="form-control" name = "current_password" id="current_password" placeholder="" value = "" required>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="designation" class="col-sm-3 col-form-label">New Password</label>
                        <div class="col-sm-9">
                          <input type="password" class="form-control" name = "password" id="password" placeholder="" value = "" required>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="designation" class="col-sm-3 col-form-label">Confirm Password</label>
                        <div class="col-sm-9">
                          <input type="password" class="form-control" name = "confirm_password" id="confirm_password" placeholder="" value = "" required>
                        </div>
                      </div>


                      <div class="form-group row">
                        <div class="offset-sm-3 col-sm-9">
                          <button type="submit" class="btn btn-default">Change</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.change password -->
                  <!-- /.tab-pane -->



                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  @endsection

  <!-- Upload file Modal -->
  <div class="modal fade" id="profile_pic">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Upload Profile Picture</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Address Modal body -->
        <div class="modal-body">
          {!! Form::open(['method' => 'POST', 'route' => ['profile.upload_pic'], 'files' => true,]) !!}
          @csrf
          <div class="form-group">
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

  @section('javascript')
  <!-- jQuery -->
  <script src="/dist/plugins/jquery/jquery.min.js"></script>
  <script src="/dist/plugins/customfiles/custom-files.min.js"></script>

  <!-- jQuery UI 1.11.4 -->
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)

    $(document).ready(function () {
      bsCustomFileInput.init();
    });

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
