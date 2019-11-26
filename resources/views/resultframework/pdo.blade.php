@extends('layouts.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Project Development Obejectives (PDO)</h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Result framework</li>
            <li class="breadcrumb-item active">PDO Results</li>
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
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">PDO Indicators</h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="height: 500px;">
                <table class="table table-head-fixed">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>PDO Indicator</th>
                      <th>Unit</th>
                      <th>Baseline</th>
                      <th>Target</th>
                      <th>Actual</th>
                      <th>Date of Data</th>
                      <th>Comments</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td>Deviation between aggregate expenditure out turn and the original approved budget</td>
                      <td>Percentage</td>
                      <td>18.74</td>
                      <td>5</td>
                      <td>6.4</td>
                      <td>31-Dec-2018</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>2</td>
                      <td>Public Access to Key Fiscal Information</td>
                      <td>Text</td>
                      <td>Documents not made available to the public:
(1) Year-end state financial statements of the Republic of Maldives; (2) In-year budget execution reports;
(3) Contracts awarded.
Budget documents and resources available to primary service units are available in public domain.</td>
                      <td>Public disclosure of the following key fiscal information: (a) Annual budget documentation, (b) In-year budget execution reports, (c) Year-end financial statements, (d) tenders above USD 100 000.</td>
                      <td>a; b; c; Tenders above USD 100,000 are disclosed.</td>
                      <td></td>
                      <td>For b and c: propose to add a column on commitments and virements. For c: all tenders above USD 2200 have to be advertized on the gazette portal per Public Finance Regulations (PFR), chapter 10: this is done. If there have been qualifications by the AG? We have confirmation, that contracts above USD 160,000 have been centralized</td>
                    </tr>
                    <tr>
                      <td>3</td>
                      <td>Comprehensiveness of debt data recording and reporting</td>
                      <td>Text</td>
                      <td>Annual statement of debt covering domestic and external debt is prepared, but there are gaps and reconciliation problems.</td>
                      <td>Domestic and foreign debt records are complete, includes payable amount updated and reconciled quarterly. Comprehensiv e management and statistical reports (covering debt service, stock and operations) are produced at least annually.</td>
                      <td>Achieved. Same as ISR. BERs with commitmen t information , the AFS with payables as well as a regular system generated reports on payables are sufficient to meet the requirement of recording payables. Commonw ealth Secretariat Debt</td>
                      <td></td>
                      <td>publishing quarterly number on the website. IMF mission to start reporting as per IMF standards. Recording of domestic side:</td>
                    </tr>
                    <tr>
                      <td>4</td>
                      <td>SOE financial reporting and disclosure</td>
                      <td>Percentage</td>
                      <td>50</td>
                      <td>100</td>
                      <td>100</td>
                      <td></td>
                      <td>Currently published on the MoF website but a detailed and interactive portal (SOE Gateway) is being developed;</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
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
