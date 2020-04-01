<?php

namespace App\Http\Controllers\Budget;

use App\Http\Controllers\Controller;

use App\models\budget\Invoice;
use App\models\procurement\contracts;
use App\models\auth\ApprovalMatrix;
use App\models\auth\ApprovalComments;
use App\models\timeline\Timeline;
use App\models\currency\Currency;
use App\models\procurement\Variations;

use Illuminate\Http\Request;

use App\Mail\OtpTokenMail;
Use App\Events\OtpToken;

use Mail;
use Auth;

use Tzsk\Otp\Facades\Otp;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $permission = "View Invoice";
      if(auth()->user()->can($permission) == false)
      {
          abort(403);
      }
        $invoices = Invoice::select('id', 'invoice_no','invoice_date','recieved_date','terms_days','contract_id','amount','advanc_recovery','retention','pv_id','status')
            ->with('contract:id,name,contractor,currency', 'contract.currencies:id,code')
            ->get();
        // return $invoices;
        return view('budget.invoice.index', compact('invoices'));
    }
    public function create()
    {

    }
    public function store(Request $request)
    {
      $permission = "Create Invoice";
      if(auth()->user()->can($permission) == false)
      {
          abort(403);
      }

      if($request->amount > $request->balance)
      {
        return back()->with(['message' => "The balance of the contrat is less the invoice amount", 'label' => "danger"]);
      }

      //checking for invoice number
      $check_for_existing = Invoice::select('id','invoice_no','contract_id')
          ->where('invoice_no', $request->invoice_number)
          ->where('contract_id', $request->contract_id)
          ->first();

        if($check_for_existing)
        {
            return back()->with(['message' => "The invoice already exist", 'label' => "danger"]);
            }else {
              $new_invoice = new Invoice;

              $new_invoice->contract_id = $request->contract_id;
              $new_invoice->invoice_type = $request->invoice_type;
              $new_invoice->invoice_no = $request->invoice_number;
              $new_invoice->invoice_date = date('Y-m-d', strtotime($request->invoice_date));
              $new_invoice->recieved_date = date('Y-m-d', strtotime($request->invoice_received_date));
              $new_invoice->terms_days = $request->terms_days;
              $new_invoice->amount = $request->amount;
              $new_invoice->advanc_recovery = $request->advance_recovery;
              $new_invoice->retention = $request->retention;
              $new_invoice->status = 1;
              $new_invoice->save();

              //matrix record
              $model = 4;
              $varification_check = env('invoice_varification_check');
              $approval_check = env('invoice_approval_check');
              $authorization_check = env('invoice_authorization_check');
              $new_matrix = $this->new_approval_matrix($model, $new_invoice->id, $varification_check, $approval_check, $authorization_check);

              //timeline record
                  //getting contract name:
                  $contract_name = contracts::select('id','name')
                      ->where('id',$request->contract_id)
                      ->first();

              $text = "New invoice Recroded for the contract: ". $contract_name['name'];
              $variation_id = null;
              $type = 12;
              $url = "/invoice/".$new_invoice->id;
              $record_id = $new_invoice->id;
              $model_id = 4;
              $contract_id = $request->contract_id;
              $event_id = null;
              $new_timeline = $this->new_timeline($text, $variation_id, $type, $url, $record_id, $model_id, $contract_id, $event_id);

              return redirect()
                    ->route('invoice_create',$request->contract_id)
                    ->with(['message' => "The invoice recorded", 'label' => "success"]);
        }

    }
    public function show(Invoice $invoice)
    {
        //
    }
    public function edit(Invoice $invoice)
    {
        //
    }
    public function update(Request $request, Invoice $invoice)
    {
        //
    }
    public function destroy(Invoice $invoice)
    {
        //
    }


    public function reject(Request $request)
    {
      $model_id = 4;

      $matrix = $this->get_matrix(4,$request->id);
      $invoice = Invoice::select('id','contract_id')
          ->where('id',$request->id)
          ->with('contract:id,name')
          ->first();

      switch($request->level)
      {
                case 1:
                  $permission = "Verify Invoice";
                  if(auth()->user()->can($permission) != true)
                  {
                    abort(403);
                  }

                  $matrix->varification_status = 0;
                  $matrix->varification_id = Auth::id();
                  $matrix->status = 0;
                  $matrix->save();

                  // return $matrix;
                  $comment = $this->new_approval_comment($matrix['id'], $request->level,$matrix->status,$request->comment);

                  $text = "Invoice for contract: ". $invoice['contract']['name']. " verification rejected";
                  $variation_id = null;
                  $type = 12;
                  $url = "/invoice/" . $request->id;
                  $record_id = null;
                  $model_id = 4;
                  $event_id = $request->id;
                  $contract_id = $invoice['contract']['id'];
                  $timeline = $this->new_timeline($text, $variation_id, $type, $url, $record_id, $model_id, $contract_id, $event_id);

                  $invoice->status = 0;
                  $invoice->save();
                  return redirect()->route('invoice.timeline', [$invoice->id])->with(['message' => "Reject Successful", 'label' => "success"]);
                break;

                case 2:
                  $permission = "Approve Invoice";
                  if(auth()->user()->can($permission) != true)
                  {
                    abort(403);
                  }

                  $matrix->approval_status = 0;
                  $matrix->approval_id = Auth::id();
                  $matrix->status = 0;
                  $matrix->save();

                  $comment = $this->new_approval_comment($matrix['id'], $request->level,$matrix->status,$request->comment);

                  $text = "Invoice for contract: ". $invoice['contract']['name']. " approval rejected";
                  $variation_id = null;
                  $type = 12;
                  $url = "/invoice/" . $request->id;
                  $record_id = null;
                  $model_id = 4;
                  $event_id = $request->id;
                  $contract_id = $invoice['contract']['id'];
                  $timeline = $this->new_timeline($text, $variation_id, $type, $url, $record_id, $model_id, $contract_id, $event_id);

                  $invoice->status = 0;
                  $invoice->save();

                  return redirect()->route('invoice.timeline', [$invoice->id])->with(['message' => "Reject Successful", 'label' => "success"]);
                  break;
                case 3:
                  $permission = "Authorize Invoice";
                  if(auth()->user()->can($permission) != true)
                  {
                    abort(403);
                  }
                  $matrix->authorize_status = 0;
                  $matrix->authorize_id = Auth::id();
                  $matrix->status = 0;
                  $matrix->save();

                  $comment = $this->new_approval_comment($matrix['id'], $request->level,$matrix->status,$request->comment);

                  $text = "Invoice for contract: ". $invoice['contract']['name']. " Authorization rejected";
                  $variation_id = null;
                  $type = 12;
                  $url = "/invoice/" . $request->id;
                  $record_id = null;
                  $model_id = 4;
                  $event_id = $request->id;
                  $contract_id = $invoice['contract']['id'];
                  $timeline = $this->new_timeline($text, $variation_id, $type, $url, $record_id, $model_id, $contract_id, $event_id);

                  $invoice->status = 0;
                  $invoice->save();

                  return redirect()->route('invoice.timeline', [$invoice->id])->with(['message' => "Reject Successful", 'label' => "success"]);
                  break;
      }


      // return $timeline;
    }
    public function verify(Request $request)
    {
        $model_id = 4;
        $permission = "Verify Invoice";
        if(auth()->user()->can($permission) != true)
        {
          abort(403);
        }

        $matrix = $this->get_matrix($model_id,$request->id);

        $invoice = Invoice::select('id','invoice_no','amount','status','contract_id')
            ->where('id',$request->id)
            ->with('contract:id,name,currency as currency_id','contract.currency:id,xrate')
            ->first();

        if($invoice->status != 1)
        {
          abort(403);
        }

        $matrix->varification_status = 2;
        $matrix->varification_id = Auth::id();
        $matrix->status = 2;
        $matrix->save();

        $text = "Invoice for contract: ". $invoice['contract']['name']. " verified";
        $variation_id = null;
        $type = 12;
        $url = "/invoice/" . $request->id;
        $record_id = null;
        $contract_id = $invoice['contract']['id'];
        $event_id = $invoice->id;
        $timeline = $this->new_timeline($text, $variation_id, $type, $url, $record_id, $model_id, $contract_id, $event_id);

        if($matrix['approval_check'] == 0 and $matrix['authorize_check']==0)
        {
              $invoice->status = 4;
              }else {
                $invoice->status = 2;
        }

        $invoice->save();

        // return $variation;
        return redirect()->route('invoice.timeline', [$invoice->id])->with(['message' => "Verified", 'label' => "success"]);
    }
    public function approve_otp(Request $request)
    {
      $model_id = 4;
      //get exising otp
      $invoice_id = $request->id;

      $invoice_status = Invoice::find($invoice_id);
      if($invoice_status->status != 2)
      {
        abort(403);
      }

      $permission = "Approve Invoice";
      if(auth()->user()->can($permission) != true)
      {
        abort(403);
      }

      $current_otp = Auth::user()->otp;

      $otp = Otp::expiry(5)->generate(Auth::user()->id . "approve" . $request->id . $model_id);
      // $otp = Hash::make('$otp');
      if($current_otp != $otp)
      {
            Auth::user()->otp = $otp;
            Auth::user()->save();
            event(new OtpToken(Auth::user()));
            }else {
                    return view('budget.invoice.approve', compact('invoice_id'))->with(['message' => "OTP Token Mismach", 'label' => "danger"]);;
      }
      return view('budget.invoice.approve', compact('invoice_id'));
    }
    public function approve(Request $request)
    {
        $model_id = 4;
        $permission = "Approve Invoice";
        if(auth()->user()->can($permission) != true)
        {
          abort(403);
        }

        $invoice = Invoice::find($request->id);
        if($invoice->status != 2)
        {
          abort(403);
        }


        $invoice_otp = env('invoice_otp');
        if($invoice_otp == 1)
        {
            $valid = Otp::expiry(5)->match($request->otp, Auth::user()->id . "approve" . $request->id . $model_id);
            }else {
              $valid = true;
        }

        if($invoice_otp == 0 or ($invoice_otp == 1 and $valid == true))
        {
                $matrix = $this->get_matrix($model_id,$request->id);
                $contract = $this->get_contract_by_id($invoice->contract_id);

                $matrix->approval_status = 2;
                $matrix->approval_id = Auth::id();
                $matrix->status = 3;
                $matrix->save();

                $text = "Invoice for contract: ". $contract->name. " approved";
                $variation_id = null;
                $type = 12;
                $url = "/invoice/" . $request->id;
                $record_id = null;
                $contract_id = $contract->id;
                $event_id = $invoice->id;
                $timeline = $this->new_timeline($text, $variation_id, $type, $url, $record_id, $model_id, $contract_id, $event_id);

                if($matrix['authorize_check']==0)
                {
                      $invoice->status = 4;
                      }else {
                        $invoice->status = 3;
                }
                $invoice->save();
          }

        // return $matrix;
        if($valid == false)
        {
            return redirect()->route('invoice.timeline', [$request->id])->with(['message' => "OTP Token Mismach", 'label' => "danger"]);
            }else {
                    return redirect()->route('invoice.timeline', [$request->id])->with(['message' => "Approved", 'label' => "success"]);
        }

    }
    public function authorize_invoice_otp(Request $request)
    {
      $model_id = 4;
      //get exising otp
      $invoice_id = $request->id;

      $invoice_status = Invoice::find($invoice_id);
      if($invoice_status->status != 3)
      {
        abort(403);
      }

      $permission = "Authorize Invoice";
      if(auth()->user()->can($permission) != true)
      {
        abort(403);
      }

      $current_otp = Auth::user()->otp;

      $otp = Otp::expiry(5)->generate(Auth::user()->id . "authorize" . $request->id . $model_id);
      // $otp = Hash::make('$otp');
      if($current_otp != $otp)
      {
            Auth::user()->otp = $otp;
            Auth::user()->save();
            event(new OtpToken(Auth::user()));
            }else {
                    return view('budget.invoice.authorize_invoice', compact('invoice_id'))->with(['message' => "OTP Token Mismach", 'label' => "danger"]);;
      }
      return view('budget.invoice.authorize_invoice', compact('invoice_id'));
    }
    public function authorize_invoice(Request $request)
    {
        $model_id = 4;
        $permission = "Authorize Invoice";
        if(auth()->user()->can($permission) != true)
        {
          abort(403);
        }

        $invoice = Invoice::find($request->id);
        if($invoice->status != 3)
        {
          abort(403);
        }


        $invoice_otp = env('invoice_otp');
        if($invoice_otp == 1)
        {
            $valid = Otp::expiry(5)->match($request->otp, Auth::user()->id . "authorize" . $request->id . $model_id);
            }else {
              $valid = true;
        }

        if($invoice_otp == 0 or ($invoice_otp == 1 and $valid == true))
        {
                $matrix = $this->get_matrix($model_id,$request->id);
                $contract = $this->get_contract_by_id($invoice->contract_id);

                $matrix->authorize_status = 2;
                $matrix->authorize_id = Auth::id();
                $matrix->status = 4;
                $matrix->save();

                $text = "Invoice for contract: ". $contract->name. " authorized";
                $variation_id = null;
                $type = 12;
                $url = "/invoice/" . $request->id;
                $record_id = null;
                $contract_id = $contract->id;
                $event_id = $invoice->id;
                $timeline = $this->new_timeline($text, $variation_id, $type, $url, $record_id, $model_id, $contract_id, $event_id);

                $invoice->status = 4;
                $invoice->save();
          }

        // return $matrix;
        if($valid == false)
        {
            return redirect()->route('invoice.timeline', [$request->id])->with(['message' => "OTP Token Mismach", 'label' => "danger"]);
            }else {
                    return redirect()->route('invoice.timeline', [$request->id])->with(['message' => "Authorized", 'label' => "success"]);
        }

    }
    public function create_invoice($id)
    {
      $permission = "Create Invoice";
      if(auth()->user()->can($permission) == false)
      {
          abort(403);
      }

      $contract = $this->get_contract_by_id($id);
      return view('budget.invoice.create',compact('contract'));
    }
    public function timeline($id)
    {
      $permission = "View Invoice";
      if(auth()->user()->can($permission) != true)
      {
        abort(403);
      }

      //getting contrat ID
      $this_invoice = Invoice::with('contract:id,task_id','contract.task:id,text','contract.task.budget:id,task_id,budget')
        ->with('contract:id,currency as currency_id,task_id,name,duration','contract.currency:id,code')
        ->find($id);

      $model_id = 4;
      $event_id = $id;

      $contract = $this->get_contract_by_id($this_invoice->contract_id);
      $base_currency = $this->base_currency();
      $variations = $this->get_variations($this_invoice->contract_id);
      $timelines = $this->get_timeline($model_id, $event_id);
      $matrix = $this->get_matrix($model_id,$id);
      $invoice_otp = env('invoice_otp');

      $reject_comments = ApprovalComments::select('id','comment','type_id','level_id')
          ->where('matrix_id',$matrix['id'])
          ->get();

      // return $contract;
      return view('budget.invoice.timeline', compact
        (
            'this_invoice',
            'base_currency',
            'variations',
            'timelines',
            'matrix',
            'reject_comments',
            'invoice_otp',
            'contract'
          ));
    }
    public function invoice_pending($id)
    {
      $permission = "View Invoice";
      if(auth()->user()->can($permission) == false)
      {
          abort(403);
      }
        $invoices = Invoice::select('id', 'invoice_no','invoice_date','recieved_date','terms_days','contract_id','amount','advanc_recovery','retention','pv_id','status')
            ->with('contract:id,name,contractor,currency', 'contract.currencies:id,code')
            ->where('contract_id', $id)
            ->where('status','>', 0)
            ->where('status','<', 4)
            ->get();

        $contract = $this->get_contract_by_id($id);
        $filter1 = $contract->name;
        $filter2 = "Pending";

        // return $invoices;
        return view('budget.invoice.filtered', compact('invoices','filter1','filter2'));
    }
    public function invoice_all($id)
    {
      $permission = "View Invoice";
      if(auth()->user()->can($permission) == false)
      {
          abort(403);
      }
        $invoices = Invoice::select('id', 'invoice_no','invoice_date','recieved_date','terms_days','contract_id','amount','advanc_recovery','retention','pv_id','status')
            ->with('contract:id,name,contractor,currency', 'contract.currencies:id,code')
            ->where('contract_id', $id)
            ->get();

        $contract = $this->get_contract_by_id($id);
        $filter1 = $contract->name;
        $filter2 = "All";

        // return $invoices;
        return view('budget.invoice.filtered', compact('invoices','filter1','filter2'));
    }


    private function new_timeline($text, $variation_id, $type, $url, $record_id, $model_id, $contract_id, $event_id)
    {
      $user_id = Auth::id();

      $new_timeline = new Timeline;

      $new_timeline->text = $text;
      $new_timeline->task = $task ?? null;
      $new_timeline->user = $user_id;
      $new_timeline->type = $type;
      $new_timeline->url = $url ?? null;
      $new_timeline->record_id = $record_id ?? null;
      $new_timeline->variation_id = $variation_id ?? null;
      $new_timeline->model_id = $model_id ?? null;
      $new_timeline->contract_id = $contract_id ?? null;
      $new_timeline->event_id = $event_id ?? null;

      $new_timeline->save();

      return response()->json($new_timeline);
    }
    private function new_approval_matrix($model, $model_id, $varification_check, $approval_check, $authorization_check)
    {
          $approval = new ApprovalMatrix;

          $approval->model = $model;
          $approval->model_id = $model_id;
          $approval->varification_check = $varification_check;
          $approval->varification_status = 1;
          $approval->varification_id = null;

          $approval->approval_check = $approval_check;
          $approval->approval_status = 1;
          $approval->approval_id = null;

          $approval->authorize_check = $authorization_check;
          $approval->authorize_status = 1;
          $approval->authorize_id = null;

          $approval->status = 1;
          $approval->save();
          return response()->json($approval);
    }
    private function base_currency()
    {
      $base_currency_id = env('base_currency_id');
      return Currency::find($base_currency_id);
    }
    private function get_variations($id)
    {
      return Variations::select('id','contract_id','variation_amount','status','id as record_id')
            ->where('contract_id',$id)
            ->whereIn('status',[1,2,3])
            ->with('contract:id,currency as currency_id', 'contract.currency:id,xrate,code')
            ->with('timeline:record_id,id,text,type')
            ->get();
    }
    private function get_timeline($model_id, $event_id)
    {
      return Timeline::select('text','task','user as user_id','type','updated_at','record_id')
          ->where('model_id',$model_id)
          ->where('event_id',$event_id)
          ->with('user:id,name')
          ->orderBy('updated_at', 'DESC')
          ->get();
    }
    private function get_matrix($model,$id)
    {
      return ApprovalMatrix::where('model',$model)
          ->where('model_id',$id)
          ->first();

    }
    private function get_contract_by_id($id)
    {
      return contracts::select('id','contract_no','name', 'currency as currency_id', 'amount', 'contractor','date','duration', 'id as contract_id')
          ->where('id',$id)
          ->with('currency:id,code')
          ->with('variations:id,contract_id,variation_amount,status')
          ->with('invoices:id,contract_id,amount,advanc_recovery,retention,status')
          ->first();
    }
    private function new_approval_comment($matrix_id, $level_id,$type_id,$comment)
    {
      $new_comment = new ApprovalComments;
      $new_comment->matrix_id = $matrix_id;
      $new_comment->level_id = $level_id;
      $new_comment->type_id = $type_id;
      $new_comment->comment = $comment;
      $new_comment->status = 1;
      $new_comment->save();

      return $new_comment;
    }
}
