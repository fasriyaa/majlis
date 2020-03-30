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
          <h1 class="m-0 text-dark">Invoice Timeline</h1>
          <p>Invoice No.
            <font color = "{{$col1}}">
                {{$this_invoice->invoice_no}}
            </font>
          </p>
          <p>Contractor :
            <font color = "{{$col1}}">
                {{$contract->contractor}}
            </font>
          </p>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href = "/invoice">Invoices</a></li>
            <li class="breadcrumb-item active">Timeline</li>
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
            <div class="col-md-6">
              <div class="card card-info">
                <div class="card-header">
                  <h3 class="card-title">Time Line</a></h3>
                </div>
                <!-- /. card header -->

                <div class="card-body table-responsive p-0">
                  <table class="table table-hover">

                    <tr align = "left">
                      <th>Date</th>
                      <th>Text</th>
                      <th>By</th>
                    </tr>

                    @foreach($timelines as $timeline)
                      <tr>
                          <td>{{date('d M Y', strtotime($timeline->updated_at))}}</td>
                          <td>
                              {{$timeline->text}}
                          </td>
                          <td>{{$timeline->user['name']}}</td>
                      </tr>
                    @endforeach

                  </table>
                </div>
                <!-- /. card body -->
              </div>
              <!-- /. card -->

          </div>
          <!-- /.left col -->

          <!-- Right Col -->
          <div class="col-sm-6">

                @if(Session::has('message'))
                <div class = "col-sm-12">
                    <p class="alert alert-{{Session::get('label')}}">{{ Session::get('message') }}</p>
                </div>
                @endif

            <!-- This this invoice details -->
                <div class = "col-sm-12">
                  <div class="card card">
                    <div class="card-header">
                      <h3 class="card-title">This Invoice | <font color = "${{$col1}}"> Invoice No. {{$this_invoice->invoice_no}}</font></h3>
                    </div>
                    <!-- /. card header -->

                    <div class="card-body table-responsive p-0">
                      <table class="table table-hover">

                            @if($this_invoice['amount'] != null)
                                <tr>
                                  <td>
                                       Payable Amount:
                                  </td>
                                  <td>
                                      {{$contract->currency->code}} {{number_format($this_invoice['amount'])}}
                                  </td>
                                </tr>
                            @endif
                            <tr>
                              <td>
                                  Invoice Status:
                              </td>
                              <td>
                                <?php $break = 0; ?>
                                  @if($this_invoice['status'] == 0)
                                      <?php $status = "Rejected"; $col = "Red"; ?>
                                  @endif
                                  @if($this_invoice['status'] == 1)
                                      @if($matrix['varification_check'] ==1 and $matrix['varification_status'] == 1)
                                        <?php $status = "Pending Varification"; $col = "orange";  $break = 1;?>
                                      @endif
                                      @if($break == 0 and $matrix['approval_check'] ==1 and $matrix['approval_status'] == 1)
                                        <?php $status = "Pending Approval"; $col = "orange"; $break = 2; ?>
                                      @endif
                                      @if($break == 0 and $matrix['authorize_check'] ==1 and $matrix['authorize_status'] == 1)
                                        <?php $status = "Pending Authorize"; $col = "orange"; $break = 3; ?>
                                      @endif

                                  @endif
                                  @if($this_invoice['status'] == 2)
                                      @if($break == 0 and $matrix['approval_check'] ==1 and $matrix['approval_status'] == 1)
                                        <?php $status = "Pending Approval"; $col = "orange"; $break = 2; ?>
                                      @endif
                                      @if($break == 0 and $matrix['authorize_check'] ==1 and $matrix['authorize_status'] == 1)
                                        <?php $status = "Pending Authorize"; $col = "orange"; $break = 3; ?>
                                      @endif
                                  @endif
                                  @if($this_invoice['status'] == 3)
                                      @if($break == 0 and $matrix['authorize_check'] ==1 and $matrix['authorize_status'] == 1)
                                        <?php $status = "Pending Authorize"; $col = "orange"; $break = 3; ?>
                                      @endif
                                  @endif
                                  @if($this_invoice['status'] == 4)
                                      <?php $status = "Settlement Pending"; $col = "orange"; ?>
                                  @endif
                                  @if($this_invoice['status'] == 5)
                                      <?php $status = "Setteled"; $col = "Green"; ?>
                                  @endif
                                    <font color = "{{$col}}">
                                      {{$status}}
                                    </font>
                              </td>
                            </tr>
                            @if($this_invoice['status']==0)
                                <tr>
                                  <td>
                                      Rejection Comment:
                                  </td>
                                  <td>
                                      @foreach($reject_comments as $comments)
                                        @if($comments->type_id == 0)
                                          {{$comments->comment}}
                                          <?php break; ?>
                                        @endif
                                      @endforeach
                                  </td>
                                </tr>
                            @endif
                            <tr align = "right">
                                <td></td>
                                  <td field-key='action'>
                                    <?php $check_break = 0; ?>
                                    @if($this_invoice['status'] > 0)

                                        @if($matrix['varification_check']!=0 and $matrix['varification_status']==1)
                                          @can('Verify Invoice')
                                            <div class="btn-group">
                                              <button type="submit" class="btn btn-danger" data-toggle="modal" data-target="#reject_invoice">Reject</button>
                                            </div>
                                            <div class="btn-group">
                                              <button type="button" class="btn btn-info" data-toggle="modal" data-target="#verify_invoice">Verify</button>
                                            </div>
                                          @endcan
                                          <?php $check_break = 1; ?>
                                        @endif

                                        @if($check_break == 0 and $matrix['approval_check']!=0 and $matrix['approval_status']==1)
                                          @can('Approve Invoice')
                                          <div class="btn-group">
                                            <button type="submit" class="btn btn-danger" data-toggle="modal" data-target="#reject_invoice">Reject</button>
                                          </div>
                                            <div class="btn-group">
                                              <button type="button" class="btn btn-info" data-toggle="modal" data-target="#approve_invoice">Approve</button>
                                            </div>
                                          @endcan
                                          <?php $check_break = 2; ?>
                                        @endif

                                        @if($check_break == 0 and $matrix['authorize_check']!=0 and $matrix['authorize_status']==1)
                                          @can('Authorize Invoice')
                                          <div class="btn-group">
                                            <button type="submit" class="btn btn-danger" data-toggle="modal" data-target="#reject_invoice">Reject</button>
                                          </div>
                                            <div class="btn-group">
                                              <button type="button" class="btn btn-info" data-toggle="modal" data-target="#authorize_invoice">Authorize</button>
                                            </div>
                                          @endcan
                                          <?php $check_break = 3; ?>
                                        @endif
                                    @endif
                                  </td>


                            </tr>
                      </table>
                    </div>
                  </div>
                </div>
            <!-- /. this invoice detials -->

            <!-- variation & Bud detials -->
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="card card">
                <div class="card-header">
                  <h3 class="card-title"><font color = "#176781"> Contract Detials</font></h3>
                </div>
                <!-- /.card-header -->

                  <div class="card-body">
                    <div class="form-group">
                        <p>Contract Name : <font color = "#176781">{{$contract->name}}</font></p>
                        <p>Contract Currency : <font color = "#176781">{{$contract->currency->code}}</font></p>
                        <p>Contract Expiry : <font color = "#176781">{{date('d F Y', strtotime($contract->date . ' + '. $contract->duration . ' days'))}}</font></p>
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
                                  @if($invoice['status'] > 1 and $invoice['status'] < 5)
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
                  <input type = "hidden" name = "balance" value = "{{$contract['amount']+ $total_variation - $total_paid - $total_pending}}">
                  <input type = "hidden" name = "xrate" value = "">
                  <input type = "hidden" name = "contract_name" value = "">
                </form>
              </div>
              <!-- /.card -->
            </div>
            <!-- /. contract & variaiotn detials -->

            <!-- Pending Action Table -->
            <?php $approval_count = 0;  ?>
            @if($approval_count>0)
              <div class = "col-sm-12">
                <div class="card card">
                  <div class="card-header">
                    <h3 class="card-title"><font color = "red">Pending Actions</font></a></h3>
                  </div>
                  <!-- /. card header -->

                  <div class="card-body table-responsive p-0">
                        <table class="table table-hover">

                              <tr>
                                <td>Pending Approval From: </td>
                                <td></td>
                                <td>

                                      <a href="#" class="btn btn-sm btn-warning fa fa-times" data-toggle="modal" data-target="#cancel_approval_modal" data-id = "" onclick = "$('#subtask2_id').val($(this).data('id'));"></a>

                                      <a href="#" class="btn btn-sm btn-info fa fa-check" data-toggle="modal" data-target="#approve_modal" data-id = "" onclick = "$('#subtask3_id').val($(this).data('id'));"></a>

                              </td>
                              </tr>



                            <tr>
                                <td>Document Required</td>
                                <td></td>
                                <td>

                                    <a href="#" class="btn btn-sm btn-warning fa fa-times" data-toggle="modal" data-target="#cancel_doc_modal" data-id = "" onclick = "$('#subtask5_id').val($(this).data('id'));"></a>

                                </td>
                            </tr>

                        </table>
                  </div>
                </div>
              </div>
            @endif
            <!-- /. Pending Action Table -->


            <!-- Left Documents Table -->
            <?php $doc_count = 1; ?>
            @if($doc_count>0)
                <div class = "col-sm-12">
                  <div class="card card">
                    <div class="card-header">
                      <h3 class="card-title">Documents</h3>
                    </div>
                    <!-- /. card header -->

                    <div class="card-body table-responsive p-0">
                      <table class="table table-hover">
                        <tr align = "left">
                          <th>Document Name</th>
                          <th>Date</th>
                        </tr>
                        <!-- foreach() -->
                            <tr>
                              <td><a href = "{{ url('/files', ) }}"></a></td>
                              <td></td>
                            </tr>
                        <!-- endforeach -->
                      </table>
                    </div>
                  </div>
                </div>
            @endif
            <!-- /. Left Documents Table -->


            <!-- Left Comments Table -->
            <div class = "col-sm-12">

            </div>
            <!-- /. Left Comments Table -->
          </div>
          <!-- /. Right Col -->

        </div>
      <!-- /. row -->
      </div>
    <!-- /.Fluid Container -->
    </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

<!-- Upload file Modal -->
<div class="modal fade" id="upload_invoice">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Upload Contract</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Address Modal body -->
      <div class="modal-body">
        {!! Form::open(['method' => 'POST', 'route' => ['contracts.upload'], 'files' => true,]) !!}
        @csrf
        <div class="form-group">
          <input type="hidden" name = "contract_id" value = "{{$contract['id']}}">
          <input type="hidden" name = "req_doc_type" value = "4">
          <div class="custom-file">
            <input type="file" name = "file" class="custom-file-input" id="customFile">
            <label class="custom-file-label" for="customFile">Choose file</label>
          </div>
        </div>
      </div>
      <!-- /. Address Modal body -->

      <!-- Modal footer -->
      <div class="modal-footer">
        <button id = "upload_doc" type="submit" class="btn btn-info">Upload</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

      </div>
        {!! Form::close() !!}
    </div>
  </div>
</div>
<!-- /. upload file modal -->

<!-- Reject Variation modal -->
<div class="modal fade" id="reject_invoice">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Reject Invoice</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Address Modal body -->
      <div class="modal-body">
        {!! Form::open(['method' => 'POST', 'route' => ['invoice.reject'], 'files' => false,]) !!}
        <div class="form-group">
          <input type="hidden" name = "id" value = "{{$this_invoice['id']}}">
          <input type="hidden" name = "level" value = "{{$check_break}}">
          <label for="name">Reason for rejecting the variation*</label>
          <textarea name = "comment" class="form-control" rows="3" value = "" required></textarea>
        </div>
      </div>
      <!-- /. link to a task Modal body -->

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="submit" class="btn btn-info">Reject</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>

      </div>
        {!! Form::close() !!}
    </div>
  </div>
</div>
<!-- /.Reject Variation Modal -->

<!-- Approve Variation modal -->
<div class="modal fade" id="approve_invoice">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Approve Invoice</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Address Modal body -->
      <div class="modal-body">
        @if($invoice_otp == 0)
          {!! Form::open(['method' => 'POST', 'route' => ['invoice.approve'], 'files' => false,]) !!}
        @endif
        @if($invoice_otp == 1)
          {!! Form::open(['method' => 'POST', 'route' => ['invoice.approve_otp'], 'files' => false,]) !!}
        @endif

        <input type="hidden" name = "id" value = "{{$this_invoice['id']}}">

        @if($invoice_otp == 0)
        <div class="form-group">
          <label for="name">Are you sure you want to approve this invoice</label>
        </div>
        @endif

        @if($invoice_otp==1)
        <div class="form-group">
          <label for="name">How would you like to send OTP Token</label>
          <select id = "otp_type" name="otp_type" class="custom-select">
              <option value="1" >E-Mail</option>
              <!-- <option value="2" >Mobile Number</option> -->
          </select>
        </div>
        @endif
      </div>

      <!-- /. link to a task Modal body -->

      <!-- Modal footer -->
      <div class="modal-footer">
        @if($invoice_otp == 0)
          <button type="submit" class="btn btn-info">Approve</button>
        @endif
        @if($invoice_otp == 1)
          <button type="submit" class="btn btn-info">Send OTP</button>
        @endif
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>

      </div>
        {!! Form::close() !!}
    </div>
  </div>
</div>
<!-- /.verifty Variation Modal -->

<!-- Verify Variation modal -->
<div class="modal fade" id="verify_invoice">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Verification of Invoice</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Address Modal body -->
      <div class="modal-body">
          {!! Form::open(['method' => 'POST', 'route' => ['invoice.verify'], 'files' => false,]) !!}
        <div class="form-group">
          <input type="hidden" name = "id" value = "{{$this_invoice['id']}}">
          <label for="name">Are you sure you want to verify the invoice</label>
        </div>
      </div>
      <!-- /. link to a task Modal body -->

      <!-- Modal footer -->
      <div class="modal-footer">
          <button type="submit" class="btn btn-info">Verify</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>

      </div>
        {!! Form::close() !!}
    </div>
  </div>
</div>
<!-- /.approve Variation Modal -->


<!-- Approve Variation modal -->
<div class="modal fade" id="authorize_invoice">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Authorize Invoice</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Address Modal body -->
      <div class="modal-body">
        @if($invoice_otp == 0)
          {!! Form::open(['method' => 'POST', 'route' => ['invoice.authorize_invoice'], 'files' => false,]) !!}
        @endif
        @if($invoice_otp == 1)
          {!! Form::open(['method' => 'POST', 'route' => ['invoice.authorize_invoice_otp'], 'files' => false,]) !!}
        @endif

        <input type="hidden" name = "id" value = "{{$this_invoice['id']}}">

        @if($invoice_otp == 0)
        <div class="form-group">
          <label for="name">Are you sure you want to Authorize this invoice</label>
        </div>
        @endif

        @if($invoice_otp==1)
        <div class="form-group">
          <label for="name">How would you like to send OTP Token</label>
          <select id = "otp_type" name="otp_type" class="custom-select">
              <option value="1" >E-Mail</option>
              <!-- <option value="2" >Mobile Number</option> -->
          </select>
        </div>
        @endif
      </div>

      <!-- /. link to a task Modal body -->

      <!-- Modal footer -->
      <div class="modal-footer">
        @if($invoice_otp == 0)
          <button type="submit" class="btn btn-info">Authorize</button>
        @endif
        @if($invoice_otp == 1)
          <button type="submit" class="btn btn-info">Send OTP</button>
        @endif
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>

      </div>
        {!! Form::close() !!}
    </div>
  </div>
</div>
<!-- /.authorize Variation Modal -->

@section('javascript')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="/dist/plugins/customfiles/custom-files.min.js"></script>

<script type="text/javascript">

function reject_variation(id)
{
      $.ajax({
      method: "POST",
      url: '/variation/reject',
      data: {
              "_token": "{{ csrf_token() }}",
              "id": id
              },
                success: function (response) {
                    // $('.collapse').collapse('show');
                    // $('#task_link_budget').html(response)
                    alert(response);
                },
                error: function (request, status, error) {
                    alert(request.responseText);
                  }
      });
}

// function request_token(id)
// {
//
//       $.ajax({
//       method: "POST",
//       url: '/otp/request',
//       data: {
//               "_token": "{{ csrf_token() }}",
//               "id": id
//               },
//                 success: function (response) {
//                     // $('.collapse').collapse('show');
//                     // $('#task_link_budget').html(response)
//                     // alert(response);
//                 },
//                 error: function (request, status, error) {
//                     // alert(request.responseText);
//                   }
//       });
// }



//view of selected upload file
$(document).ready(function () {
  bsCustomFileInput.init();
});

</script>
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
