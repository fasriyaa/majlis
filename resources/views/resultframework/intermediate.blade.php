@extends('layouts.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Intermediate Indicators</h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Result framework</li>
            <li class="breadcrumb-item active">Intermediate Indicators</li>
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
                <h3 class="card-title">Intermediate Indicators</h3>

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
                      <th>Intermediate Indicator</th>
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
                      <td>Increased capacity on macro fiscal planning</td>
                      <td>Text</td>
                      <td>0% of staff trained on macro fiscal planning.
No credible MTFF and framework for assessing investment projects exists.</td>
                      <td>Production of a Macro fiscal forecasting tool to inform the annual budget</td>
                      <td>i)MTFF produced and used to prepare Fiscal Strategy Paper that was sent to parliament and used for the preparation of 2020 budget.
ii) Final Macro fiscal forecasting tool exists and was used for MTFF
iii) Draft ToR is being prepared</td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>2</td>
                      <td>Capacity building on procurement through the implementation of a new Procurement curricula</td>
                      <td>Text</td>
                      <td>Nil</td>
                      <td>15</td>
                      <td></td>
                      <td></td>
                      <td>Around 150 participants have been trained through in-house curricula available within the MoF. However, these are not affiliated with any accreditations.</td>
                    </tr>
                    <tr>
                      <td>3</td>
                      <td>BERs subjected to audit by internal auditors</td>
                      <td>Percentage</td>
                      <td>0</td>
                      <td>100</td>
                      <td>0</td>
                      <td></td>
                      <td>BERs exist but not subjected to internal audit.</td>
                    </tr>
                    <tr>
                      <td>4</td>
                      <td>Updated gender disaggregated statistics to inform fiscal policy</td>
                      <td>Text</td>
                      <td>No recent data on household income/expenditures</td>
                      <td>Findings from HHIES have been published</td>
                      <td>Ongoing. Results of the HHIES expected Sept 2020</td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>5</td>
                      <td>Improved asset management</td>
                      <td>Text</td>
                      <td>Asset registry not annexed to AFS</td>
                      <td>End year Financial Statements with asset registry</td>
                      <td>Asset portal has been developed and is currently being rolled out. Asset registry is compiled through the portal.</td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>6</td>
                      <td>Inclusion of CPA techniques in Performance Audit</td>
                      <td>Text</td>
                      <td>No use of CPA</td>
                      <td>Two pilot Performance Audits conducted using CPA</td>
                      <td>Not done. ToR has been developed</td>
                      <td></td>
                      <td>BERs exist but not subjected to internal audit.</td>
                    </tr>
                    <tr>
                      <td>7</td>
                      <td>Increased capacity on debt and cash management</td>
                      <td>Text</td>
                      <td>Credible DMS does not exist.</td>
                      <td>Debt management strategy produced</td>
                      <td>Rolling MTDS produced and published for 2020- 2022</td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>8</td>
                      <td>Timely preparation of annual financial statements</td>
                      <td>Text</td>
                      <td>AFS not accepted by audit as complete and ready for audit.</td>
                      <td>System- generated AFS submitted to audit within 4 months from year end.</td>
                      <td>AFS 2018 was submitted within four months on April 2019, working towards IPSAS compliance. Task force on accrual accounting established for IPSAS and working on a roadmap.</td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>9</td>
                      <td>Improved communication of PFM reforms</td>
                      <td>Text</td>
                      <td>No PFM communication strategy</td>
                      <td>Communicatio n strategy exists
All planned consultation workshops held for legal and business process review
Fifteen change management workshops for key stakeholders held in total by end of FY5. stakeholders held in total by end of FY5.</td>
                      <td>Change managemen t strategy with a Communic ation plan. The change managemen t strategy is yet to be developed and will be submitted by November 18, 2019</td>
                      <td></td>
                      <td></td>
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
