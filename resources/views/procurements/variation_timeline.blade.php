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
          <h1 class="m-0 text-dark">Timeline of:</h1>
          @foreach($variation['timeline'] as $timeline)
            @if($timeline['type'] == 11)
              <p>Variation :
                <font color = "{{$col1}}">
                    {{$timeline['text']}}
                </font>
              </p>
              <?php break; ?>
            @endif
          @endforeach
          <p>contract :
            <font color = "{{$col1}}">
              {{$contract['name']}}
            </font>
          </p>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active"><a href = "/variations">variations</a></li>
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

            <!-- This variation details -->
                <div class = "col-sm-12">
                  <div class="card card">
                    <div class="card-header">
                      <h3 class="card-title">This Variation</h3>
                    </div>
                    <!-- /. card header -->

                    <div class="card-body table-responsive p-0">
                      <table class="table table-hover">
                            @if($variation['variation_amount'] != null)
                                <tr>
                                  <td>
                                      Variation Amount:
                                  </td>
                                  <td>
                                      {{$contract['currency']['code']}} {{number_format($variation['variation_amount'])}}
                                  </td>
                                </tr>
                            @endif
                            @if($variation['variation_duration'] != null)
                                <tr>
                                  <td>
                                      Variation Duration:
                                  </td>
                                  <td>
                                      {{number_format($variation['variation_duration'])}} Days
                                  </td>
                                </tr>
                            @endif
                            <tr>
                              <td>
                                  Variation Status:
                              </td>
                              <td>
                                <?php $break = 0; ?>
                                  @if($variation['status'] == 0)
                                      <?php $status = "Rejected"; $col = "Red"; ?>
                                  @endif
                                  @if($variation['status'] == 1)
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
                                  @if($variation['status'] == 2)
                                      @if($break == 0 and $matrix['approval_check'] ==1 and $matrix['approval_status'] == 1)
                                        <?php $status = "Pending Approval"; $col = "orange"; $break = 2; ?>
                                      @endif
                                      @if($break == 0 and $matrix['authorize_check'] ==1 and $matrix['authorize_status'] == 1)
                                        <?php $status = "Pending Authorize"; $col = "orange"; $break = 3; ?>
                                      @endif
                                  @endif
                                  @if($variation['status'] == 3)
                                      @if($break == 0 and $matrix['authorize_check'] ==1 and $matrix['authorize_status'] == 1)
                                        <?php $status = "Pending Authorize"; $col = "orange"; $break = 3; ?>
                                      @endif
                                  @endif
                                  @if($variation['status'] == 4)
                                      <?php $status = "Effective"; $col = "Green"; ?>
                                  @endif
                                    <font color = "{{$col}}">
                                      {{$status}}
                                    </font>
                              </td>
                            </tr>
                            @if($variation['status']==0)
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
                                    @if($variation['status'] > 0)
                                        @canany(['Verify Variations', 'Approve Variations', 'Authorize Variations'])
                                          @if($variation['status']!= 4)
                                            <div class="btn-group">
                                              <button type="submit" class="btn btn-danger" data-toggle="modal" data-target="#reject_variation">Reject</button>
                                            </div>
                                          @endif
                                        @endcanany

                                        @if($matrix['varification_check']!=0 and $matrix['varification_status']==1)
                                          @can('Verify Variations')
                                            <div class="btn-group">
                                              <button type="button" class="btn btn-info" data-toggle="modal" data-target="#verify_variation">Verify</button>
                                            </div>
                                          @endcan
                                          <?php $check_break = 1; ?>
                                        @endif

                                        @if($check_break == 0 and $matrix['approval_check']!=0 and $matrix['approval_status']==1)
                                          @can('Approve Variations')
                                            <div class="btn-group">
                                              <button type="button" class="btn btn-info" data-toggle="modal" data-target="#approve_variation">Approve</button>
                                            </div>
                                          @endcan
                                          <?php $check_break = 2; ?>
                                        @endif

                                        @if($check_break == 0 and $matrix['authorize_check']!=0 and $matrix['authorize_status']==1)
                                          @can('Authorize Variations')
                                            <div class="btn-group">
                                              <button type="button" class="btn btn-info" data-toggle="modal" data-target="#authorize_variation">Authorize</button>
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
            <!-- /. this variation detials -->

            <!-- variation & Bud detials -->
            <div class="col-md-12">
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
                                        - Contract: {{$other_contract->name}}:
                                      @else

                                        - Contract: {{$other_contract->name}}:
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
                                                - Variation: {{$timelines['text']}}:
                                              @else

                                                  - Variation: {{$timelines['text']}}:
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
                  <input type = "hidden" name = "contract_name" value = "{{$contract['name']}}">
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
<div class="modal fade" id="upload_contract">
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
<div class="modal fade" id="reject_variation">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Reject Variation</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Address Modal body -->
      <div class="modal-body">
        {!! Form::open(['method' => 'POST', 'route' => ['variation.reject'], 'files' => false,]) !!}
        <div class="form-group">
          <input type="hidden" name = "id" value = "{{$variation['id']}}">
          <input type="hidden" name = "level" value = "{{$check_break}}">
          <label for="name">Reason for rejecting the variation*</label>
          <textarea name = "comment" class="form-control" rows="3" value = "" required></textarea>
        </div>
      </div>
      <!-- /. link to a task Modal body -->

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="submit" class="btn btn-info">Save</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>

      </div>
        {!! Form::close() !!}
    </div>
  </div>
</div>
<!-- /.Reject Variation Modal -->

<!-- Approve Variation modal -->
<div class="modal fade" id="approve_variation">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Approve Variation</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Address Modal body -->
      <div class="modal-body">
        {!! Form::open(['method' => 'POST', 'route' => ['variation.approve'], 'files' => false,]) !!}
        <div class="form-group">
          <input type="hidden" name = "id" value = "{{$variation['id']}}">
          <label for="name">Are you sure you want to approve the variation</label>
        </div>
      </div>
      <!-- /. link to a task Modal body -->

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="submit" class="btn btn-info">Approve</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>

      </div>
        {!! Form::close() !!}
    </div>
  </div>
</div>
<!-- /.verifty Variation Modal -->

<!-- Verify Variation modal -->
<div class="modal fade" id="verify_variation">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Verification of Variation</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Address Modal body -->
      <div class="modal-body">
        {!! Form::open(['method' => 'POST', 'route' => ['variation.verify'], 'files' => false,]) !!}
        <div class="form-group">
          <input type="hidden" name = "id" value = "{{$variation['id']}}">
          <label for="name">Are you sure you want to verify the variation</label>
        </div>
      </div>
      <!-- /. link to a task Modal body -->

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="submit" class="btn btn-info">Save</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>

      </div>
        {!! Form::close() !!}
    </div>
  </div>
</div>
<!-- /.approve Variation Modal -->


<!-- Approve Variation modal -->
<div class="modal fade" id="authorize_variation">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Authorize Variation</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Address Modal body -->
      <div class="modal-body">
        {!! Form::open(['method' => 'POST', 'route' => ['variation.authorize_variation'], 'files' => false,]) !!}
        <div class="form-group">
          <input type="hidden" name = "id" value = "{{$variation['id']}}">
          <label for="name">Are you sure you want to authorize the variation</label>
        </div>
      </div>
      <!-- /. link to a task Modal body -->

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="submit" class="btn btn-info">Authorize</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>

      </div>
        {!! Form::close() !!}
    </div>
  </div>
</div>
<!-- /.verifty Variation Modal -->

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
