@extends('layouts.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">New Variation</h1>
          <h8 class="m-0 text-dark">Contract Name: {{$contract['name']}}</h8>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href = "/contracts">Contracts</a></li>
            <li class="breadcrumb-item"><a href = "">Variations</a></li>
            <li class="breadcrumb-item active">New</li>
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
                        <h3 class="card-title">New Variation Details</h3>
                      </div>
                      <!-- /.card-header -->
                      <!-- form start -->
                      {!! Form::open(['method' => 'POST', 'route' => ['variations.store'], 'files' => false,]) !!}
                      <input type = "hidden" name = "contract_id" value = "{{$contract['id']}}">
                        <div class="card-body">
                          <div class="form-group">
                            <label for="name">Change Contract Amount <font color="#75320f">[{{$contract['currency']['code']}}]</font> to :</label>
                            <input type = "number" step = ".01" class = "form-control" name = "amount" value = "{{$contract['amount']}}">
                          </div>
                          <div class="form-group">
                            <label for="name">Change Contract Duration <font color="#75320f">[DAYS]</font> to:</label>
                            <input type = "number" step = "1" class = "form-control" name = "duration" value = "{{$contract['duration']}}">
                          </div>

                          @if(Session::has('message'))
                              <p class="alert alert-{{Session::get('label')}}">{{ Session::get('message') }}</p>
                          @endif

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                          <button type="submit" class="btn btn-info">Submit</button>
                        </div>
                      <!-- </form> -->
                    </div>
                    <!-- /.card -->
                  </div>
        <!-- /. left coloumn -->

        <!-- Right column -->
                  <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card">
                      <div class="card-header">
                        <h3 class="card-title"><font color = "#176781"> Contract & Budget Details</font></h3>
                      </div>
                      <!-- /.card-header -->

                        <div class="card-body">
                          <div class="form-group">
                              <?php if($contract['currency_id'] == 1){$currency = "MVR";}else{$currency = "USD";} ?>
                              <p>Task : <font color = "#176781"> {{$contract['task']['text']}}</font></p>
                              <p>Contract Name : <font color = "#176781">{{$contract['name']}}</font></p>
                              <p>Contract Currency : <font color = "#176781">{{$contract['currency']['code']}}</font></p>
                              <p>Contract Expiry : <font color = "#176781">{{date('d F Y',strtotime($contract['date']. '+ '.$contract['duration'].'days'))}}</font></p>
                              <table class="table table-condensed">
                                <tr>
                                  <td>Budget: </td>
                                  <td></td>
                                  <td>
                                      <font color = "green">
                                        {{$base_currency['code']}} {{number_format($contract['task']['budget']['budget'])}}
                                      </font>
                                  </td>
                                </tr>


                                @foreach($other_contracts as $other_contract)
                                    <tr>
                                        <td>
                                            @if($base_currency['id']==$other_contract->currency_id)
                                              - {{$other_contract->name}}:
                                            @else

                                              - {{$other_contract->name}}:
                                                <font color = "grey">
                                                  ~approximated
                                                </font>
                                            @endif
                                        </td>
                                        <td></td>
                                        <td><font color = "red">({{$base_currency['code']}}{{number_format($other_contract->base_curr_eqv)}})</font></td>
                                    </tr>
                                <?php $contract['task']['budget']['budget'] = $contract['task']['budget']['budget'] - $other_contract->base_curr_eqv; ?>
                                  @if($other_contract->id == $contract['id'])
                                    <?php $xrate = $other_contract->currency['xrate']; ?>
                                  @endif
                                @endforeach

                                <?php $total_variation = 0; ?>
                                @foreach($variations as $variation)
                                    <tr>
                                        <td>
                                            @foreach($variation->timeline as $timelines)
                                              @if($timelines['type'] == 11)
                                                    @if($base_currency['id']==$variation->contract['currency']['code'])
                                                      - {{$timelines['text']}}:
                                                    @else

                                                        - {{$timelines['text']}}:
                                                        <font color = "grey">
                                                          ~approximated
                                                        </font>
                                                    @endif
                                                    <?php break; ?>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                          <font color = "red">
                                            {{$base_currency['code']}} {{number_format($variation->variation_amount/$variation->contract['currency']['xrate'])}}
                                          </font>
                                        </td>
                                        <td>

                                        </td>
                                    </tr>
                                <?php $total_variation = $total_variation + $variation->variation_amount/$variation->contract['currency']['xrate']; ?>
                                @endforeach



                                <tr>
                                    <td> - Total Pending Variations </td>
                                    <td> </td>
                                    <td>
                                      <?php if($total_variation == 0){$col = "grey";}else{$col="red";} ?>
                                      <font color = "{{$col}}">
                                        ({{$base_currency['code']}} {{number_format($total_variation)}})
                                      </font>
                                    </td>
                                </tr>
                                <tr>
                                    <td> Available Balance </td>
                                    <td> </td>
                                    <td>
                                      @if($contract['task']['budget']['budget'] - $total_variation < 0)
                                        <?php $col = "red"; ?>
                                      @else
                                        <?php $col = "green"; ?>
                                      @endif
                                      <font color = "{{$col}}">
                                            {{$base_currency['code']}} {{number_format($contract['task']['budget']['budget'] - $total_variation)}}

                                      </font>
                                    </td>
                                </tr>


                              </table>
                          </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">

                        </div>
                        <input type = "hidden" name = "balance" value = "{{$contract['task']['budget']['budget'] - $total_variation}}">
                        <input type = "hidden" name = "xrate" value = "{{$xrate}}">
                      </form>
                    </div>
                    <!-- /.card -->
                  </div>
        <!-- /. Right coloumn -->






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
