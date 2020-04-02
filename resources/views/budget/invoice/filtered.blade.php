@extends('layouts.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">{{$filter2}} Invoices</h1>
          <p>Contact: {{$filter1}}</p>
        </div>

        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Pending Invoices</li>
          </ol>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row mb-2">
        <div class="col-sm-1">
            @can('Create Invoice')
            <a href = "{{route('invoice_create',[$contract_id])}}"><button type="button" class="btn btn-info">New Invoice</button></a>
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
                      <th>Invoice Number</th>
                      <th>Contract Name</th>
                      <th>Contractor</th>
                      <th>Date of Invoice</th>
                      <th>Received Date</th>
                      <th>Payable in [Days]</th>
                      <th>Due Date</th>
                      <th>Currency</th>
                      <th>Payable Amount</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                  <?php $count = 1; ?>
                  @foreach($invoices as $invoice)
                      <tr>
                        <td>{{$count}}</td>
                        <td>{{$invoice->invoice_no}}</td>
                        <td>{{$invoice->contract->name}}</td>
                        <td>{{$invoice->contract->contractor}}</td>
                        <td>{{date('d F Y', strtotime($invoice->invoice_date))}}</td>
                        <td>{{date('d F Y', strtotime($invoice->recieved_date))}}</td>
                        <td>{{$invoice->terms_days}}</td>
                        <td>{{date('d F Y', strtotime($invoice->recieved_date . ' +' .$invoice->terms_days. ' days' ))}}</td>
                        <td>{{$invoice->contract->currencies->code}}</td>
                        <td>{{number_format($invoice->amount)}}</td>
                        <td>
                            @if($invoice->status == 0)
                              <?php $status = "Rejected"; $col = "red"; ?>
                            @endif
                            @if($invoice->status == 1)
                              <?php $status = "Vefication Pending"; $col = "orange"; ?>
                            @endif
                            @if($invoice->status == 2)
                              <?php $status = "Approval Pending"; $col = "orange"; ?>
                            @endif
                            @if($invoice->status == 3)
                              <?php $status = "Authorization Pending"; $col = "orange"; ?>
                            @endif
                            @if($invoice->status == 4)
                              <?php $status = "Settlement Pending"; $col = "orange"; ?>
                            @endif
                            @if($invoice->status == 5)
                              <?php $status = "Settled"; $col = "green"; ?>
                            @endif
                            <font color = "{{$col}}">
                                {{$status}}
                            </font>
                        </td>
                        <td field-key='action'>
                          <div class="btn-group">
                            <button type="button" class="btn btn-info">Action</button>
                            <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown">

                              <div class="dropdown-menu" role="menu">
                                <a class="dropdown-item" href="" onclick ="location.href='/invoice/timeline/' + {{$invoice->id}};">Timeline</a>
                                <a class="dropdown-item" href="" onclick ="location.href='/contracts/timeline/' + {{$invoice->contract->id}};">View Contract</a>
                                @can('Edit Invoice')
                                  <a class="dropdown-item" href="{{route('contracts.create')}}">Edit</a>
                                @endcan
                                <a class="dropdown-item" href="">Upload Invoice</a>
                                <div class="dropdown-divider"></div>

                              </div>
                            </button>
                          </div>
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
