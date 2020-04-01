@extends('layouts.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">New Timebase Plan</h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active"><a href = "/contracts">Contracts</a></li>
            <li class="breadcrumb-item active">New Timebase plan</li>
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

        <!-- left column -->
                  <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-info">
                      <div class="card-header">
                        <h3 class="card-title">New Timebase Plan - <font color = "orange">{{$base_currency->code}}</font></h3>
                      </div>
                      <!-- /.card-header -->
                      <!-- form start -->
                      {!! Form::open(['method' => 'POST', 'route' => ['timebased_planed.store'], 'files' => false,]) !!}
                        <div class="card-body">
                          <input type = "hidden" name="contract_id" value = "{{$contract->id}}">
                          <!-- <div class="form-group">
                            <label for="name">Invoice Type</label>
                            <select id = "type" name="invoice_type" class="custom-select">
                                <option value="1" >Progress</option>
                                <option value="2" >Advance</option>
                                <option value="3" >Retention</option>
                            </select>
                          </div> -->

                          <div class="form-group row">
                            <label for="designation" class="col-sm-4 col-form-label">Remuneration - Days<font color = "red">*</font></label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control" id="designation" name = "rem_days" placeholder="" value = "" required>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="designation" class="col-sm-4 col-form-label">Remuneration - Rate <font color = "red">*</font></label>
                            <div class="col-sm-8">
                              <input type="number" step = ".01" class="form-control" id="designation" name = "rem_rate" placeholder="" value = "" required>
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="designation" class="col-sm-4 col-form-label">Per Diem - Days</label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control" id="designation" name ="perdiem_days" placeholder="" value = "">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="designation" class="col-sm-4 col-form-label">Per Diem - Rate</label>
                            <div class="col-sm-8">
                              <input type="number" step = ".01" class="form-control" id="designation" name = "perdiem_rate" placeholder="" value = "">
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="designation" class="col-sm-4 col-form-label">Number of Trips</label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control" id="designation" name = "trip_days" placeholder="" value = "">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="designation" class="col-sm-4 col-form-label">Rate Per Trip</label>
                            <div class="col-sm-8">
                              <input type="number" step = ".01" class="form-control" id="designation" name = "trip_rate" placeholder="" value = "">
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="designation" class="col-sm-4 col-form-label">Number of Transfers</label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control" id="designation" name = "transfer_days" placeholder="" value = "">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="designation" class="col-sm-4 col-form-label">Rate Per Transfer</label>
                            <div class="col-sm-8">
                              <input type="number" step = ".01" class="form-control" id="designation" name = "transfer_rate" placeholder="" value = "" required>
                            </div>
                          </div>


                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                          <button type="submit" class="btn btn-info">Submit</button>
                        </div>

                    </div>
                    <!-- /.card -->
                  </div>
        <!-- /. left coloumn -->

        <!-- Right Coloumn -->

        <div class="col-sm-6">

          @if(Session::has('message'))
          <div class = "col-sm-12">
              <p class="alert alert-{{Session::get('label')}}">{{ Session::get('message') }}</p>
          </div>
          @endif

          @canany('Create Contract Type','Create Currency')
          <!-- Action Table  -->
            <!-- <div class = "col-sm-12">
              <div class="card card">
                <div class="card-header">
                  <h3 class="card-title">Task Actions</a></h3>
                </div>


                <div class="card-body table-responsive p-0">
                  <table class="table table-hover">

                    @can('Create Contract Type')
                    <tr align = "left">
                      <td></td>
                      <td data-toggle="modal" data-target="#create_contract_type">Actions 1</td>
                      </td>
                    </tr>
                    @endcan

                  </table>
                </div>
              </div>
            </div> -->
          @endcanany
          <!-- /action table -->

          <!-- Contract Details -->
          <div class="card card">
            <div class="card-header">
              <h3 class="card-title"><font color = "#176781"> Contract Details</font></h3>
            </div>
            <!-- /.card-header -->

              <div class="card-body">
                <div class="form-group">
                    <p>Contract Name : <font color = "#176781">{{$contract['name']}}</font></p>
                    <p>Contractor : <font color = "#176781">{{$contract['contractor']}}</font></p>
                    <p>Contract Amount : <font color = "#176781">{{$contract['currency']['code']}} {{number_format($contract['amount'])}}</font></p>
                    <p>Duration: <font color = "#176781">{{number_format($contract['duration'])}} Days</font></p>
                    <p>Contract Expiry : <font color = "#176781">{{date('d F Y', strtotime($contract['date'] . '+'. $contract['duration']. 'days'))}}</font></p>


                    <table class="table table-condensed">
                      <tr>
                          <td>
                            A. Contract Amount {{$contract['currency']['code']}}
                          </td>
                          <td> </td>
                          <td>
                            <font color = "green">
                              {{number_format($contract['amount'])}}
                            </font>
                          </td>
                      </tr>

                      <tr>
                          <td>
                            B. Effective Variations {{$contract['currency']['code']}}
                          </td>
                          <td>
                            <?php $total_variation = 0; ?>
                            @foreach($contract->variations as $variation)
                              @if($variation->status == 4)
                                <?php $total_variation = $total_variation + $variation['variation_amount']; ?>
                              @endif
                            @endforeach
                            @if($total_variation < 0)
                                <?php $col = "red"; ?>
                                @else
                                  <?php $col = "green"; ?>
                            @endif
                            <font color = "{{$col}}">
                              {{number_format($total_variation)}}
                            </font>
                          </td>
                          <td>

                          </td>
                      </tr>

                      <tr>
                          <td>
                            C. Paid Amount {{$contract['currency']['code']}}
                          </td>
                          <td>
                            <?php $total_paid = 0; ?>
                            @foreach($contract->invoices as $invoice)
                              @if($invoice['status'] == 5)
                                <?php $total_paid = $total_paid + $invoice['amount']; ?>
                              @endif
                            @endforeach
                            <font color ="red">
                                {{number_format($total_paid)}}
                            </font>
                          </td>
                          <td>

                          </td>
                      </tr>

                      <tr>
                          <td>
                            D. Pending Invoices {{$contract['currency']['code']}}
                          </td>
                          <td>
                            <?php $total_pending = 0; ?>
                            @foreach($contract->invoices as $invoice)
                              @if($invoice['status'] > 0 and $invoice['status'] < 5)
                                <?php $total_pending = $total_pending + $invoice['amount']; ?>
                              @endif
                            @endforeach
                            <font color ="red">
                                {{number_format($total_pending)}}
                            </font>
                          </td>
                          <td>

                          </td>
                      </tr>

                      <tr>
                          <td>
                            Net (E = B - C - D) {{$contract['currency']['code']}}
                          </td>
                          <td>

                          </td>
                          <td>
                            <font color ="red">
                                {{number_format($total_variation - $total_paid + $total_pending)}}
                            </font>
                          </td>
                      </tr>

                      <tr>
                          <td>
                            F. Balance (F = A - E) {{$contract['currency']['code']}}
                          </td>
                          <td>

                          </td>
                          <td>
                            <font color ="green">
                                {{number_format($contract['amount']+ $total_variation - $total_paid - $total_pending)}}
                            </font>
                          </td>
                      </tr>

                    </table>
                </div>
              </div>
              <!-- /.card-body -->

              <div class="card-footer">

              </div>
          </div>
          <!-- /.card -->
          <input type = "hidden" name = "balance" value = "{{$contract['amount']+ $total_variation - $total_paid - $total_pending}}">
          </form>
        </div>
    <!-- /.right coloumn -->




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

  $(document).ready(function () {
      $('#datepicker').datepicker({
        uiLibrary: 'bootstrap'
      });
      $('#datepicker1').datepicker({
        uiLibrary: 'bootstrap'
      });
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
