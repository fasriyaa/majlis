@extends('layouts.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Linking the contract to project task</h1>
          <h8 class="m-0 text-dark">Contract Name: {{$contract['name']}}</h8>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href = "/contracts">Contracts</a></li>
            <li class="breadcrumb-item active">Link</li>
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
                        <h3 class="card-title">New Link</h3>
                      </div>
                      <!-- /.card-header -->
                      <!-- form start -->
                      {!! Form::open(['method' => 'POST', 'route' => ['contracts.link_task'], 'files' => false,]) !!}
                      <input type = "hidden" name = "contract_id" value = "{{$contract['id']}}">
                        <div class="card-body">
                          <div class="form-group">
                            <label for="task">Select a Task</label>
                            <select id = "task_id" name="task_id" class="form-control form-control-lg select2" style="width: 100%; height: 100% !important;" onChange="update(this, {{$contract['id']}});">
                              @foreach($tasks as $task)
                                @if($task->budget['budget'] > $contract['base_curr_eqv'])
                                  <option value="{{$task->id}}" >{{$task->id}} | {{$task->text}} - {{$base_currency}} {{number_format($task->budget['budget'])}}</option>
                                @endif
                              @endforeach
                            </select>
                            <div class="form-group">
                              <br>
                            </div>
                            <table class="table table-condensed" id="task_link_budget">

                            </table>
                          </div>

                          @if(Session::has('message'))
                              <p class="alert alert-{{Session::get('label')}}">{{ Session::get('message') }}</p>
                          @endif

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-info">Submit</button>
                        </div>
                      </form>
                    </div>
                    <!-- /.card -->
                  </div>
        <!-- /. left coloumn -->

        <!-- Right column -->
                  <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card">
                      <div class="card-header">
                        <h3 class="card-title">Contract Details</h3>
                      </div>
                      <!-- /.card-header -->

                        <div class="card-body">
                          <div class="form-group">
                              <p>Contract No : {{$contract['contract_no']}}</p>
                              <p>Contract Name : {{$contract['name']}} </p>
                              <p>Contractor : {{$contract['contractor']}}</p>
                              <table class="table table-condensed">
                                <tr>
                                  <td>Contract Amount in contract currency: </td>
                                  <td>{{$contract['currency']['code']}} : {{number_format($contract['amount'])}} </td>
                                </tr>
                                @if($contract['amount'] != $contract['base_curr_eqv'])
                                  <tr>
                                    <td>Contract Amount in base currency: </td>
                                    <td>{{$base_currency}} : {{number_format($contract['base_curr_eqv'])}}</td>
                                  </tr>
                                @endif

                                <tr>
                                    <td>Contract Expiry : </td>
                                    <td>{{date('d F Y', strtotime($contract['date'] . ' + '.$contract['duration'] .'days'))}}</td>
                                </tr>
                              </table>
                          </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">

                        </div>
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
<!-- select2 plugin -->
<script src="/dist/plugins/select2/select2.full.min.js"></script>
<!-- /select 2 plugin -->
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

<script type="text/javascript">

    function update(object, contract_id)
    {
        var id = object.value;
        $.ajax({
        method: "POST",
        url: '/task_link_budget',
        data: {
                "_token": "{{ csrf_token() }}",
                "id": id,
                "contract_id": contract_id
        },
          success: function (response) {
              $('.collapse').collapse('show');
              $('#task_link_budget').html(response)
              // alert(response);
          },
          error: function (request, status, error) {
              alert(request.responseText);
            }
        });

    }

    $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

  });


</script>
@stop
