@extends('layouts.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Activities of:</h1>
          <p>ALL</p>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">.....</li>
            <li class="breadcrumb-item active">Sub Components</li>
            <li class="breadcrumb-item active">Activities</li>
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
          <div class="col-md-12">

            <!-- Main node for this component -->
              <div class="timeline">
              <!-- Timeline time label -->
              <div class="time-label">
                <span class="navbar-green">23 Aug. 2019</span>
              </div>
              <div>
              <!-- Before each timeline item corresponds to one icon on the left scale -->
                <i class="fas fa-envelope bg-blue"></i>
                <!-- Timeline item -->
                <div class="timeline-item">
                <!-- Time -->
                  <span class="time"><i class="fas fa-clock"></i> 12:05</span>
                  <!-- Header. Optional -->
                  <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>
                  <!-- Body -->
                  <div class="timeline-body">
                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                    weebly ning heekya handango imeem plugg dopplr jibjab, movity
                    jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                    quora plaxo ideeli hulu weebly balihoo...
                  </div>
                  <!-- Placement of additional controls. Optional -->
                  <div class="timeline-footer">
                    <a class="btn btn-primary btn-sm">Read more</a>
                    <a class="btn btn-danger btn-sm">Delete</a>
                  </div>
                </div>
              </div>
              <!-- The last icon means the story is complete -->
              <div>
                <i class="fas fa-clock bg-gray"></i>
              </div>
              </div>

          </div>
          <!-- /.col -->
        </div>
      <!-- /. row -->
      </div>
    <!-- /.Fluid Container -->
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
