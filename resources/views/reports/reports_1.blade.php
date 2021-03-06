@extends('layouts.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Meetings</h1>
          <p>ALL</p>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Meetings</li>
          </ol>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="row mb-2">

      </div>
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
          <div class="card card-info card-outline">
            <div class="card-header">
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
              <table id = "vendor_table" class="table table-hover datatable">
                <thead>
                    <tr align = "left">
                      <th>#</th>
                      <th align = "left">Member Name</th>
                      <th align = "left">Constituency</th>
                      <th align = "left">Date</th>
                      <th align = "left">Time & Duration</th>
                      <th align = "right">Participants</th>
                    </tr>
              </thead>

              <tbody>
                <?php $count = 1; ?>
                @foreach($meetings as $meeting)
                    <tr onclick = "">
                      <td>{{$count}}</td>
                      <td>{{$meeting->member->name}}</td>
                      <td>{{$meeting->member->constituency}}</td>
                      <td>{{date('d M Y', strtotime($meeting->date))}}</td>
                      <td>{{date('H:i', strtotime($meeting->meeting_time))}}</td>
                      <td>

                        <?php $count2 = 1; ?>
                        <table>
                        @foreach($meeting->participants as $participant)

                          <tr>
                            <td>{{$count2}}. {{$participant->name}} (ID: {{$participant->id_no}})</td>
                          </tr>

                          <?php $count2++; ?>
                        @endforeach
                        </table>
                      </td>


                    </tr>
                <?php $count++; ?>
                @endforeach
              </tbody>

              </table>
            </div>
            <!-- /.card-body -->
            <!-- Card Footer -->
            <div class="card-footer clearfix">

            </div>
            <!-- /. Card footer -->
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
<!-- DataTables -->
<!-- <script>
    window.deleteButtonTrans = 'Delete';
    window.copyButtonTrans = 'Copy';
    window.csvButtonTrans = 'csv';
    window.excelButtonTrans = 'Excel';
    window.pdfButtonTrans = 'pdf';
    window.printButtonTrans = 'print';
    window.colvisButtonTrans = 'coloumn visibility';
</script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.0/js/buttons.flash.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.0/js/buttons.print.min.js"></script>

<!-- <script src="/dist/plugins/datatables/jquery.dataTables.js"></script>
<script src="/dist/plugins/datatables/dataTables.bootstrap4.js"></script> -->
<!-- /. Datatables -->
<script>
$(document).ready(function() {
    $('#vendor_table').DataTable( {
        dom: 'Bfrtip',
        buttons: [{
            extend: 'pdfHtml5',
            customize: function(doc) {
             doc.styles.tableHeader.alignment = 'left';
           }
        }]
    } );
} );

  // $(function () {
  //   $("#progress_table").DataTable();
  //
  //   $('#example2').DataTable({
  //     "paging": true,
  //     "lengthChange": false,
  //     "searching": false,
  //     "ordering": true,
  //     "info": true,
  //     "autoWidth": false,
  //   });
  // });


</script>
@stop
