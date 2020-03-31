@extends('layouts.master')
@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Reports</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Reports</li>
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

            <!-- General Reports -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                </div>
                  <table class="table table-condensed">
                    <tr>
                        <td onclick ="location.href='/reports/1';">PV with Contract Category [USD] </td>
                    </tr>
                    <tr>
                        <td onclick ="location.href='/reports/2';">PV with Components [USD] </td>
                    </tr>
                  </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          </div>
          <!-- /.col -->


          <div class="col-md-9">
            <div class="card card-primary card-outline">
              <div class="card-header p-2">
                <ul class="nav">
                  <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Progress</a></li>
                  <li class="nav-item"><a class="nav-link" href="#edit" data-toggle="tab">Budget</a></li>
                  <li class="nav-item"><a class="nav-link" href="#edit" data-toggle="tab">Others</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="settings">

                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="edit">
                    <!-- <form class="form-horizontal"> -->


                  </div>
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
