@extends('layouts.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Meeting | 27 November 2019</h1>
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
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Item</th>
                      <th>Submitted by:</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1.</td>
                      <td>Project Discription</td>
                      <td>PMU</td>
                    </tr>

                    <tr>
                      <td>2.</td>
                      <td>Project Timeline</td>
                      <td>PMU</td>
                    </tr>

                    <tr>
                      <td>3.</td>
                      <td>Project Progress</td>
                      <td>PMU</td>
                    </tr>

                    <tr>
                      <td>4.</td>
                      <td>Accrual Accounting TOR</td>
                      <td>Financial Controller</td>
                    </tr>


                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <button type="submit" class="btn btn-info float-right">New</button>
              </div>


            </div>
            <!-- /.card -->
          </div>
          <!-- /. col -->

          <!-- Documents -->
                <div class="col-md-6">
                      <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Reference Documents</h3>


                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                          <table class="table table-striped">
                            <thead>
                              <tr>
                                <th style="width: 10px">#</th>
                                <th>Document Name</th>
                                <th>Document Date:</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>1.</td>
                                <td><a href = "files/27_11_2019_ppt.pdf">Project Desription PPT</a></td>
                                <td>27 November 2019</td>
                              </tr>

                              <tr>
                                <td>2.</td>
                                <td><a href = "/files/pad.pdf">Project Apraisal Document</a></td>
                                <td>20 June 2018</td>
                              </tr>

                              <tr>
                                <td>3.</td>
                                <td><a href = "/files/2019_q3.pdf">2019 Q3 Progress Report</a></td>
                                <td>15 November 2019</td>
                              </tr>

                              <tr>
                                <td>4.</td>
                                <td><a href = "/files/AM_27_11_2019.pdf">Draft Aide Memore | 12-14 Nov 2019</a></td>
                                <td>27 November 2019</td>
                              </tr>

                              <tr>
                                <td>5.</td>
                                <td><a href = "/files/Accrual_Accounting_TOR.pdf">Draft Accural Accounting TOR</td>
                                <td>27 November 2019</td>
                              </tr>


                            </tbody>
                          </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                          <button type="submit" class="btn btn-info float-right">Add</button>
                        </div>
                      </div>
                      <!-- /.card -->

                      <!-- Meeting Minutes -->
                      <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Meeting Minutes: <font color = "red">Not Available</font> |<a href = "#"> Upload</a></h3>
                        </div>
                        <!-- /.card-header -->

                        <!-- /.card-body -->
                      </div>
                      <!-- /.card -->
                      <!-- /. Meeting Minutes -->

                      <!-- Meeting Minutes -->
                      <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Attendence: <font color= "red">Not Available</font> |<a href = "#"> Upload</a></h3>
                        </div>
                        <!-- /.card-header -->

                        <!-- /.card-body -->
                      </div>
                      <!-- /.card -->
                      <!-- /. Meeting Minutes -->

                      <!-- Notes -->
                      <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Notes</font></h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                          <table class="table table-striped">
                            <thead>
                              <tr>
                                <th style="width: 10px">#</th>
                                <th>Member</th>
                                <th>View</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>1.</td>
                                <td>PMU Notes</td>
                                <td>Public</td>
                                <td><a href = "#">Show</a></td>
                              </tr>

                              <tr>
                                <td>2.</td>
                                <td>Ahmed Ameer</td>
                                <td>Private</td>
                                <td></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>

                        <!-- /.card-body -->
                        <div class="card-footer">
                          <button type="submit" class="btn btn-info float-right">New Note</button>
                        </div>
                      </div>
                      <!-- /.card -->
                      <!-- /. Notes -->



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
