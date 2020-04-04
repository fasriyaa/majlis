@extends('layouts.master')
@section('content')
<?php $col1 = "#176781"; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Timebase sheet</h1>
          <p>Contradt No:
            <font color = "{{$col1}}">
              {{$contract->contract_no}}
            </font>
          </p>
          <p>
            Contract Name:
            <font color = "{{$col1}}">
               {{$contract->name}}
            </font>
          </p>
        </div>


        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item">Timebase</li>
            <li class="breadcrumb-item active">Sheet</li>
          </ol>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row mb-2">

      </div>
      <div class="row mb-2">
        <div class="col-sm-1">
            @can('Edit Timebaseplan')
            <a href = "{{route('timebased_planed.edit', [$timebaseplan->id])}}"><button type="button" class="btn btn-info">Edit Timebaseplan</button></a>
            @endcan
        </div>
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
          <div class="card">
            <!-- <div class="card-header"> -->
              <!-- <h3 class="card-title">List</h3> -->

              <!-- <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                  <div class="input-group-append">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div> -->
            <!-- </div> -->
            <!-- /.card-header -->
            <div class="card-body table-responsive">
              <table id = "contracts_table" class="table table-hover">
                <thead>
                    <tr align = "left">
                      <th>#</th>
                      <th>Invoice No</th>
                      <th>Invoice Date</th>
                      <th>Remuneration Days Used</th>
                      <th>Balance</th>
                      <th>Remuneration Rate - {{$base_currency->code}}</th>
                      <th>Total Remuneration - {{$base_currency->code}}</th>
                      <th>Per Diem Days used</th>
                      <th>Balance </th>
                      <th>Per Diem Rate - {{$base_currency->code}}</th>
                      <th>Total Per Diem - {{$base_currency->code}}</th>
                      <th>Trip Days used</th>
                      <th>Balance</th>
                      <th>Trip Rate - {{$base_currency->code}}</th>
                      <th>Trip Total - {{$base_currency->code}} </th>
                      <th>Transfer days used </th>
                      <th>Blance</th>
                      <th>Transfer rate - {{$base_currency->code}}</th>
                      <th>Transfer Total - {{$base_currency->code}} </th>
                      <th>Grand Total - {{$base_currency->code}}</th>
                    </tr>
                </thead>

                <tbody>
                  <?php $count = 1; ?>
                      <tr>
                        <td>{{$count}}</td>
                        <td> Initial </td>
                        <td> Plan </td>
                        <td>{{number_format(0)}}</td>
                        <td>{{number_format($timebaseplan->rem_days)}}</td>
                        <td> {{number_format($timebaseplan->rem_rate)}}</td>
                        <td>{{number_format(0)}}</td>
                        <td>{{number_format(0)}}</td>
                        <td>{{number_format($timebaseplan->perdiem_days)}}</td>
                        <td>{{number_format($timebaseplan->perdiem_rate)}}</td>
                        <td>{{number_format(0)}}</td>
                        <td>{{number_format(0)}}</td>
                        <td>{{number_format($timebaseplan->trip_days)}}</td>
                        <td>{{number_format($timebaseplan->trip_rate)}}</td>
                        <td>{{number_format(0)}}</td>
                        <td>{{number_format(0)}}</td>
                        <td>{{number_format($timebaseplan->transfer_days)}}</td>
                        <td>{{number_format($timebaseplan->transfer_rate)}}</td>
                        <td>{{number_format(0)}}</td>
                        <td>{{number_format(0)}} </th>
                      </tr>
                  <?php $count++; ?>
                  <?php $rem_bal = $timebaseplan->rem_days;
                        $perdiem_bal = $timebaseplan->perdiem_days;
                        $trip_bal = $timebaseplan->trip_days;
                        $transfer_bal = $timebaseplan->transfer_days;
                        $rem_total = 0;
                        $perdiem_total = 0;
                        $trip_total = 0;
                        $transfer_total = 0;
                  ?>
                  @foreach($timebase_actuals as $actual)
                      <tr>
                        <td>{{$count}}</td>
                        <td>{{$actual->invoice->invoice_no}}</td>
                        <td>{{date('d M Y',strtotime($actual->invoice->invoice_date))}} </td>
                        <td>{{number_format($actual->rem_days)}}</td>
                        <td>{{number_format($rem_bal = $rem_bal - $actual->rem_days)}}</td>
                        <td> {{number_format($timebaseplan->rem_rate)}}</td>
                        <td>{{number_format($actual->rem_days * $timebaseplan->rem_rate)}}</td>
                        <td>{{number_format($actual->perdiem_days)}}</td>
                        <td>{{number_format($perdiem_bal = $perdiem_bal - $actual->perdiem_days)}}</td>
                        <td>{{number_format($timebaseplan->perdiem_rate)}}</td>
                        <td>{{number_format($actual->perdiem_days * $timebaseplan->perdiem_rate)}}</td>
                        <td>{{number_format($actual->trip_days)}}</td>
                        <td>{{number_format($trip_bal = $trip_bal - $actual->trip_days)}}</td>
                        <td>{{number_format($actual->trip_rate)}}</td>
                        <td>{{number_format($actual->trip_days*$actual->trip_rate)}}</td>
                        <td>{{number_format($actual->transfer_days)}}</td>
                        <td>{{number_format($transfer_bal = $transfer_bal - $actual->transfer_days)}}</td>
                        <td>{{number_format($actual->transfer_rate)}}</td>
                        <td>{{number_format($actual->transfer_days*$actual->transfer_rate)}}</td>
                          <?php
                            $rem_total = $rem_total + ($actual->rem_days * $timebaseplan->rem_rate);
                            $perdiem_total = $perdiem_total + $actual->perdiem_days * $timebaseplan->perdiem_rate;
                            $trip_total = $trip_total + $actual->trip_days*$actual->trip_rate;
                            $transfer_total = $transfer_total + $actual->transfer_days*$actual->transfer_rate;
                          ?>
                        <td>{{number_format($actual->rem_days * $timebaseplan->rem_rate + $actual->perdiem_days * $timebaseplan->perdiem_rate + $actual->trip_days*$actual->trip_rate + $actual->transfer_days*$actual->transfer_rate)}} </th>
                      </tr>
                    <?php $count++; ?>
                  @endforeach
                  <tr>
                    <td>{{$count}}</td>
                    <td>Grand </td>
                    <td>Total </td>
                    <td>{{number_format($timebaseplan->rem_days-$rem_bal)}}</td>
                    <td>{{number_format($rem_bal)}}</td>
                    <td> - </td>
                    <td>{{number_format($rem_total)}}</td>
                    <td>{{number_format($timebaseplan->perdiem_days-$perdiem_bal)}}</td>
                    <td>{{number_format($perdiem_bal)}}</td>
                    <td> - </td>
                    <td>{{number_format($perdiem_total)}}</td>
                    <td>{{number_format($timebaseplan->trip_days-$trip_bal)}}</td>
                    <td>{{number_format($trip_bal)}}</td>
                    <td> - </td>
                    <td>{{number_format($trip_total)}}</td>
                    <td>{{number_format($timebaseplan->transfer_days-$transfer_bal)}}</td>
                    <td>{{number_format($transfer_bal)}}</td>
                    <td> - </td>
                    <td>{{number_format($transfer_total)}}</td>
                    <td>{{number_format($rem_total + $perdiem_total + $trip_total + $transfer_total )}} </th>
                  </tr>

            </tbody>



              </table>
            </div>
            <!-- /.card-body -->
            <!-- Card Footer -->
            <div class="card-footer clearfix">
                <!-- <ul class="pagination pagination-sm m-0 float-right">
                  <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                  <li class="page-item"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                </ul> -->
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
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

<script src="/dist/plugins/datatables/jquery.dataTables.js"></script>
<script src="/dist/plugins/datatables/dataTables.bootstrap4.js"></script>
<!-- /. Datatables -->


<script>
  $(function () {
    $("#contracts_table").DataTable();

    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
    });
  });
</script>

@stop
