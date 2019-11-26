@extends('layouts.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Disbursed Linked Indicators (DLI)</h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Result framework</li>
            <li class="breadcrumb-item active">DLI</li>
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
                <h3 class="card-title">DL Indicators</h3>

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
                      <th>DLI</th>
                      <th>Baseline</th>
                      <th>Results to be achieved by June 30, 2018</th>
                      <th>Results to be achieved by June 30, 2019</th>
                      <th>Results to be achieved by June 30, 2020</th>
                      <th>Results to be achieved by June 30, 2021</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td>DLI # 1: Increased sustainability of PFM reforms and key MoFT functions through establishment of a PFDS.</td>
                      <td>No PFDS established. Ongoing hemorrhage of key personnel.</td>
                      <td>Governance structure and organogram of the PFDS has been approved by Decision of the Minister of Finance.</td>
                      <td>10 out of the 16 vacant PFDS positions are filled based on job descriptions and in a transparent manner. <br>Formula: SDR 240,000 once at least 10 of the 16 vacancies are fulfilled and SDR 18333.33 for every additional vacancy filled in the PFDS thereafter.</td>
                      <td>2019 PFDS performance report, including client/ beneficiary feedback is published on MoFT website.</td>
                      <td>N.A.</td>
                      <td>PFDS was formed by Ministerial decision on 7th February 2018. Reference: MEMO (13- HR/13/2018/190)<br>14 out of 16 staff has been hired as at 20th November 2019 and 8 have been trained and certified in use of specific SAP modules<br>Development of format for performance report, including client/ beneficiary feedback has been included in the TOR for Institutional Development Consultant (TOR to be finalized in November 2019)</td>
                    </tr>
                    <tr>
                      <td>1</td>
                      <td>DLI #1 Value: 1.05 Mio. SDR</td>
                      <td></td>
                      <td>350 000 SDR</td>
                      <td>350 000 SDR</td>
                      <td>350 000 SDR</td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>1</td>
                      <td>Status</td>
                      <td></td>
                      <td><font color = "green">Achieved</font></td>
                      <td><font color = "green">Achieved</font></td>
                      <td><font color = "orange">Pending</font></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>2</td>
                      <td>DLI#2: Strengthen control of the wage bill and staffing of core financial functions</td>
                      <td>Limited wage bill data and no specific cadres nor pay schemes for critical finance functions.</td>
                      <td>N.A.</td>
                      <td>Establishment of civil service registry by the NPC with gender disaggregated data on personnel and wages.</td>
                      <td>Approval by the NPC by way of resolution of a standardized pay classification structure for finance cadres.</td>
                      <td>100% of new MoFT cadre recruited are subject to the revised pay structure for finance cadres.</td>
                      <td>> CSR is referred to as the Payroll Register within MoF. The application for this register “Bandeyri Portal” (which includes multiple areas in addition to civil service) was launched in June 2019.<br>> Establishment of registry with gender disaggregated data on personnel and wages will be confirmed by NPC by 30th November 2019 through issuance of a circular.<br>> Work towards developing a standardized pay classification structure for finance cadres is ongoing inhouse.
Areas of pay classification and job families have been completed.
Pay structure area is remaining. Target to complete this task is end of June 2020.<br>> MoF cadre being subject to new pay structure is dependent upon completion of target 2.</td>
                    </tr>
                    <tr>
                      <td>2</td>
                      <td>DLI #2 Value: 1.05 Mio SDR</td>
                      <td></td>
                      <td></td>
                      <td>350 000 SDR</td>
                      <td>350 000 SDR</td>
                      <td>350 000 SDR</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>2</td>
                      <td>Status</td>
                      <td></td>
                      <td></td>
                      <td><font color = "orange">Pending</font></td>
                      <td><font color = "orange">Pending</font></td>
                      <td><font color = "orange">Pending</font></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>3</td>
                      <td>DLI #3: Improve oversight and monitoring of SOEs</td>
                      <td>SOE oversight and monitoring is overseen by the Privatization and Corporatization Board (PCB) Act but not fully functional.</td>
                      <td>PCB secretariat at MoF staffed with a corporate governance specialist</td>
                      <td>Joint performance monitoring framework for SOEs has been signed between the Minister of Finance and the president of the PCB.</td>
                      <td>(i) The Board of Directors of the largest 10 SOE adopted procurement guidelines issued by PCB.<br><br>Formula- SDR 280,000 once at least 8 SOEs adopts the new procurement guidelines, and SDR 35000 for every SOE that adopts the same.<br><br>(ii) The Board of Directors of the five (5) largest SOEs adopted the new corporate governance code.</td>
                      <td></td>
                      <td>Circular for JPMF was signed between Minister and President of PCB in Q2 2019.<br><br>10 largest SOE’s for the purpose of the DLI are: STO, MACL, IAS, STELCO, MTCC, Fenaka, MWSC, MPA, HDC and Wamco. To prepare the procurement guidelines, contract with selected firm is expected to be signed by 30th November 2019.<br><br>5 largest SOE’s for the purpose of DLIs are MACL, IAS STELCO, Fenaka & MWSC.
MACL, Fenaka and MWSC have adopted the new CGC as required by PCB. However, while STELCO and IAS have adopted the CGC to an extent, they are yet to completely adopt the code.</td>
                    </tr>
                    <tr>
                      <td>3</td>
                      <td>DLI #3 Value: 1.05 Mio SDR</td>
                      <td></td>
                      <td></td>
                      <td>350 000 SDR</td>
                      <td>700 000 SDR</td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>3</td>
                      <td>Status</td>
                      <td></td>
                      <td></td>
                      <td><font color = "green">Achieved</font></td>
                      <td><font color = "orange">Pending</font></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>4</td>
                      <td>DLI #4: Increasing Transparency and external accountability</td>
                      <td>Whole of Government Accounts are not consistent with legal requirements and IPSAS and are not audited</td>
                      <td></td>
                      <td>2018 Whole of Government Financial Statements are audited and published*.</td>
                      <td></td>
                      <td>The 2020 Financial Statements of the 10 largest SOEs are audited and published, including the audit opinion*. Formula: SDR [560,000] once at least 8 of the largest SOEs publish the audited financial statements, and SDR[70,000] for every such SOE that publishes the same</td>
                      <td>2018 whole of government audit will be completed by end of November 2019.<br><br>The 2020 Financial Statements of the 10 largest SOEs – audit will commence in 2021.</td>
                    </tr>
                    <tr>
                      <td>4</td>
                      <td>DLI # 4 Value: 1.05 Mio SDR</td>
                      <td></td>
                      <td></td>
                      <td>350 000 SDR</td>
                      <td></td>
                      <td>700 000 SDR</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>4</td>
                      <td>Status</td>
                      <td></td>
                      <td></td>
                      <td><font color = "orange">Pending</font></td>
                      <td></td>
                      <td><font color = "orange">Pending</font></td>
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
