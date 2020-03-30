@extends('layouts.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">New Contract</h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active"><a href = "/contracts">Contracts</a></li>
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
                        <h3 class="card-title">New contract Details</h3>
                      </div>
                      <!-- /.card-header -->
                      <!-- form start -->
                      {!! Form::open(['method' => 'POST', 'route' => ['contracts.store'], 'files' => false,]) !!}
                        <div class="card-body">

                          <div class="form-group">
                            <label for="name">Contract Type</label>
                            <select id = "type" name="type" class="custom-select">
                              @foreach($contract_types as $type)
                                <option value="{{$type->id}}" >{{$type->name}}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="name">Contract Number</label>
                            {!! Form::text('contract_no', old('contract_no'), ['class' => 'form-control', 'placeholder' => '', 'required' ] ) !!}
                          </div>
                          <div class="form-group">
                            <label for="name">Contract Name</label>
                            {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => '', 'required']) !!}
                          </div>
                          <div class="form-group">
                            <label for="name">Contract Currency</label>
                            <select id = "currency" name="currency" class="custom-select">
                                @foreach($currencies as $currency)
                                <option value="{{$currency->id}}" >{{$currency->code}}</option>
                                @endforeach
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="name">Contract Amount</label>
                            {!! Form::number('amount', old('currency'), ['step' => '.01','class' => 'form-control', 'placeholder' => '', 'required']) !!}
                          </div>
                          <div class="form-group">
                            <label for="name">Contractor</label>
                            {!! Form::text('contractor', old('contractor'), ['class' => 'form-control', 'placeholder' => '', 'required']) !!}
                          </div>

                          <div class="form-group">
                            <label for="name">Contract Date</label>
                            {!! Form::text('contract_date', old('contract_date'), ['id' => 'datepicker','class' => 'form-control', 'placeholder' => 'mm/dd/yyyy', 'required']) !!}
                          </div>

                          <div class="form-group">
                            <label for="name">Duration (days)</label>
                            {!! Form::number('duration', old('duration'), ['step' => '1', 'class' => 'form-control', 'placeholder' => '', 'required']) !!}
                          </div>

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

        <!-- Right Coloumn -->
        @canany('Create Contract Type','Create Currency')
        <div class="col-sm-6">

          @if(Session::has('message'))
          <div class = "col-sm-12">
              <p class="alert alert-{{Session::get('label')}}">{{ Session::get('message') }}</p>
          </div>
          @endif

            <div class = "col-sm-12">
              <div class="card card">
                <div class="card-header">
                  <h3 class="card-title">Task Actions</a></h3>
                </div>
                <!-- /. card header -->

                <div class="card-body table-responsive p-0">
                  <table class="table table-hover">
                    @can('Create Contract Type')
                    <tr align = "left">
                      <td></td>
                      <td data-toggle="modal" data-target="#create_contract_type">Create New Contract</td>
                      </td>
                    </tr>
                    @endcan
                    @can('Create Currency')
                    <tr align = "left">
                      <td></td>
                      <td data-toggle="modal" data-target="#create_currency">Create New Currency</td>
                      </td>
                    </tr>
                    @endcan
                  </table>
                </div>
              </div>
            </div>
        </div>
        @endcanany
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

<!-- Create Contract Type Modal -->
<div class="modal fade" id="create_contract_type">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Create New Contract Type</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Address Modal body -->
      <div class="modal-body">
        {!! Form::open(['method' => 'POST',  'route' => ['contracts.new_type'], 'files' => false,]) !!}
        <div class="form-group">
          <label for="comment_label">Contract Type*</label>
          <input type = "text" class="form-control" name ="contract_type" placeholder="" required>
        </div>
      </div>
      <!-- /. Address Modal body -->

      <!-- Modal footer -->
      <div class="modal-footer">
        <button id = "approve" type="submit" class="btn btn-info">Create</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>

      </div>
        {!! Form::close() !!}
    </div>
  </div>
</div>
<!-- /. Create Contract Type -->

<!-- Create Contract Type Modal -->
<div class="modal fade" id="create_currency">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Create New Currency</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Address Modal body -->
      <div class="modal-body">
        {!! Form::open(['method' => 'POST',  'route' => ['contracts.new_currency'], 'files' => false,]) !!}
        <div class="form-group">
          <label for="comment_label">Currency Code*</label>
          <input type = "text" class="form-control" name ="code" placeholder="" required>
        </div>
        <div class="form-group">
          <label for="comment_label">Currency Name*</label>
          <input type = "text" class="form-control" name ="name" placeholder="" required>
        </div>
        <div class="form-group">
          <label for="comment_label">Exchange Rate to Base Currency*</label>
          <input type = "number" step = ".01" class="form-control" name ="xrate" placeholder="" required>
        </div>
      </div>
      <!-- /. Address Modal body -->

      <!-- Modal footer -->
      <div class="modal-footer">
        <button id = "approve" type="submit" class="btn btn-info">Create</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>

      </div>
        {!! Form::close() !!}
    </div>
  </div>
</div>
<!-- /. Create Contract Type -->

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
