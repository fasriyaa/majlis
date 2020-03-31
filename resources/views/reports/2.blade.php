@extends('layouts.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Payment Vouchers with Components</h1>
          <p>ALL</p>
        </div>


        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Payment Vouchers</li>
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
          <?php $type1_id = $components[0]; ?>
          <?php $type2_id = $components[1]; ?>
          <?php $type3_id = $components[2]; ?>
          <?php $type4_id = $components[3]; ?>
          <?php $type5_id = $components[4]; ?>

          <?php $type1_text = $components_text[0]; ?>
          <?php $type2_text = $components_text[1]; ?>
          <?php $type3_text = $components_text[2]; ?>
          <?php $type4_text = $components_text[3]; ?>
          <?php $type5_text = $components_text[4]; ?>

            <div class="card-body table-responsive">
              <table id = "contracts_table" class="table table-hover">
                <thead>
                    <tr align = "left">
                      <th>#</th>
                      <th>PV Number</th>
                      <th>PV Date</th>
                      <th>Vendor</th>
                      <th>Invoice Number</th>
                      <th>{{$type1_text}}</th>
                      <th>{{$type2_text}}</th>
                      <th>{{$type3_text}}</th>
                      <th>{{$type4_text}}</th>
                      <th>{{$type5_text}}</th>
                    </tr>
                </thead>

                <tbody>
                  <?php $count = 1; ?>
                  <?php $type1 = 0; $type2 = 0; $type3 = 0; $type4 = 0; $type5 = 0; ?>
                  @foreach($data as $pv)
                      <tr>
                        <td>{{$count}}</td>
                        <td>{{$pv->pv_no}}</td>
                        <td>{{date('d F Y', strtotime($pv->date))}}</td>
                        <td>{{$pv->invoice->contract->contractor}}</td>
                        <td>{{$pv->invoice->invoice_no}}</td>
                        <td>
                            @if($pv->invoice->contract->task->parent_pv->parent_pv->parent_pv->parent == $type1_id)
                              {{number_format($pv->invoice->amount/$pv->invoice->contract->currencies->xrate, '2')}}
                              <?php $type1 = $type1 + round($pv->invoice->amount/$pv->invoice->contract->currencies->xrate, 2); ?>
                            @endif
                        </td>
                        <td>
                          @if($pv->invoice->contract->task->parent_pv->parent_pv->parent_pv->parent == $type2_id)
                            {{number_format($pv->invoice->amount/$pv->invoice->contract->currencies->xrate, '2')}}
                            <?php $type2 = $type2 + round($pv->invoice->amount/$pv->invoice->contract->currencies->xrate, 2); ?>
                          @endif
                        </td>
                        <td>
                          @if($pv->invoice->contract->task->parent_pv->parent_pv->parent_pv->parent == $type3_id)
                            {{number_format($pv->invoice->amount/$pv->invoice->contract->currencies->xrate, '2')}}
                            <?php $type3 = $type3 + round($pv->invoice->amount/$pv->invoice->contract->currencies->xrate, 2); ?>
                          @endif
                        </td>
                        <td>
                          @if($pv->invoice->contract->task->parent_pv->parent_pv->parent_pv->parent == $type4_id)
                            {{number_format($pv->invoice->amount/$pv->invoice->contract->currencies->xrate, '2')}}
                            <?php $type4 = $type4 + round($pv->invoice->amount/$pv->invoice->contract->currencies->xrate, 2); ?>
                          @endif
                        </td>
                        <td>
                          @if($pv->invoice->contract->task->parent_pv->parent_pv->parent_pv->parent == $type5_id)
                            {{number_format($pv->invoice->amount/$pv->invoice->contract->currencies->xrate, '2')}}
                            <?php $type5 = $type5 + round($pv->invoice->amount/$pv->invoice->contract->currencies->xrate, 2); ?>
                          @endif
                        </td>
                      </tr>
                  <?php $count++; ?>
                  @endforeach
                  <tr>
                      <td>Total</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td>{{number_format($type1,'2')}}</td>
                      <td>{{number_format($type2,'2')}}</td>
                      <td>{{number_format($type3,'2')}}</td>
                      <td>{{number_format($type4,'2')}}</td>
                      <td>{{number_format($type5,'2')}}</td>
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
