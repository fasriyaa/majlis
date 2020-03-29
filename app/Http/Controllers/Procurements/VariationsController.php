<?php

namespace App\Http\Controllers\Procurements;

use App\Http\Controllers\Controller;

use App\models\procurement\Variations;
use App\models\procurement\contracts;
use App\models\gantt\Task;
use App\models\budget\budget;
use App\models\budget\Allocation;
use App\models\auth\ApprovalMatrix;
use App\models\timeline\Timeline;
use App\models\currency\Currency;
use App\models\auth\ApprovalComments;
use App\User;

use App\Mail\OtpTokenMail;
Use App\Events\OtpToken;
use Mail;

use Tzsk\Otp\Facades\Otp;


use Illuminate\Http\Request;

use Auth;
use Redirect;
use Hash;

class VariationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $permission = "View Variations";
      if(auth()->user()->can($permission) != true)
      {
        abort(403);
      }

        $variations = Variations::select('id','contract_id','variation_amount','variation_duration','status')
            ->with('contract:id,contract_no,date,name,amount,duration,contractor,currency as currency_id', 'contract.currency:id,code')
            ->with('timeline:id,text,record_id,type')
            ->get();

        // return $variations;
        return view('procurements.variations',compact('variations'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $permission = "Create Variations";
      if(auth()->user()->can($permission) != true)
      {
          abort(403);
      }
        //checking for changes;
        $contract = contracts::select('id','amount','duration','name','task_id','currency as currency_id')
            ->where('id',$request->contract_id)
            ->with('currency:id,xrate')
            ->first();

        if($contract['amount']!=$request->amount or $contract['duration']!=$request->duration)
        {
          if($contract['amount']==$request->amount)
          {
            $amount = null;
            $text_timeline_amount = "nill change";
              }else {
                $amount = round($request->amount - $contract['amount'],2);
                $text_timeline_amount = " form ". number_format($contract['amount']) . " to ". number_format($request->amount);
          }

          if($contract['duration']==$request->duration)
          {
            $duration = null;
            $text_timeline_duration = "nill change";
              }else {
                $duration = $request->duration - $contract['duration'];
                $text_timeline_duration = " form ". $contract['duration'] . " to ". $request->duration;
          }


          if(($request->amount-$contract['amount'])/$request->xrate > $request->balance)
          {
            return back()->with(["message" => "Requested variation exceeds budget! please revise budget figure", "label" =>"danger"]);
          }else {
                  $variation = new Variations;

                  $varification_check = env('variation_varification_check');
                  $approval_check = env('variation_approval_check');
                  $authorization_check = env('variation_authorization_check');

                  $variation->contract_id = $request->contract_id;
                  $variation->variation_amount = $amount;
                  $variation->variation_duration = $duration;

                  if($varification_check == 0 and $approval_check == 0 and $authorization_check == 0)
                  {
                      $variation->status = 4;
                      $variation->base_curr_eqv = $amount/$contract['currency']['xrate'] ?? 0;
                      }else {
                        $variation->status = 1;
                  }

                  $variation->save();

                    //recording in approval matrix
                      $model = 1;
                      $model_id = $variation->id;

                      $this->new_approval_matrix($model, $model_id, $varification_check, $approval_check, $authorization_check);

                    //recording into timeline
                    $text = "Variation to change: contract amount " . $text_timeline_amount . "; and/or contract duration " . $text_timeline_duration ."; for contract: ". $contract['name'];
                    $variation_id = $variation->id;
                    $contract_id = $contract['id'];
                    $type = 11;
                    $url = "/variations/" . $model_id;
                    $record_id = $model_id;
                    $this->new_timeline($text, $variation_id, $type, $url, $record_id, $model_id, $contract_id);

                    // return $variation;
                    // return back()-> with(["message" => "saved", "label" =>"info"]);
                    return redirect()->route('contracts.timeline', [$request->contract_id]);
          }

        }else {
          // return redirect()->route('contracts.timeline', [$request->contract_id]);
          return back()-> with(["message" => "Nothing changed", "label" =>"warning"]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Variations  $variations
     * @return \Illuminate\Http\Response
     */
    public function show(Variations $variations)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Variations  $variations
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $permission = "Edit Variations";
      if(auth()->user()->can($permission) != true)
      {
          abort(403);
      }
        // getting contract details;
            //getting contrat ID
            $variation = Variations::with('timeline')
              ->with('contract:id,task_id','contract.task:id,text','contract.task.budget:id,task_id,budget')
              ->with('contract:id,currency as currency_id,task_id,name','contract.currency:id,code')
              ->find($id);

            $contract = $variation['contract'];
            $base_currency = $this->base_currency();
            $other_contracts = $this->other_contracts($contract['task_id']);
            $contracts_id = $this->id_to_array($other_contracts);
            $variations = $this->get_variations($contracts_id);
            $effective_variation_amount = Variations::select('id','base_curr_eqv','status')
                ->whereIn('contract_id',$contracts_id)
                ->where('status',4)
                ->get()->sum('base_curr_eqv');

            // return $contract['name'];
            return view('procurements.edit_variation', compact
              (
                'contract',
                'base_currency',
                'other_contracts',
                'variations',
                'variation',
                'effective_variation_amount'
              ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Variations  $variations
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $permission = "Edit Variations";
      if(auth()->user()->can($permission) != true)
      {
          abort(403);
      }
        //checking for changes;
        $variation = Variations::find($id);

        if($variation['variation_amount']!=$request->variation_amount or $variation['variation_duration']!=$request->variation_duration)
        {
          if($variation['variation_amount']==$request->variation_amount)
          {
            $amount = null;
            $text_timeline_amount = "nill change";
              }else {
                $amount = round($request->variation_amount - $variation['variation_amount'],2);
                $text_timeline_amount = " form ". number_format($variation['variation_amount']) . " to ". number_format($request->variation_amount);
          }

          if($variation['variation_duration']==$request->variation_duration)
          {
            $duration = null;
            $text_timeline_duration = "nill change";
              }else {
                $duration = $request->variation_duration - $variation['variation_duration'];
                $text_timeline_duration = " form ". $variation['variation_duration'] . " to ". $request->variation_duration;
          }

          if(($request->variation_amount - $variation['variation_amount'])/$request->xrate > $request->balance)
          {
            return back()->with(["message" => "Requested variation exceeds budget! please revise budget figure", "label" =>"danger"]);
          }else {

                  $variation->variation_amount = $request->variation_amount;
                  $variation->variation_duration = $request->variation_duration;
                  $variation->save();

                  $model = null;
                  $model_id = null;
                    //recording into timeline
                    $text = "Variation Edited " . $text_timeline_amount . "; and/or contract duration " . $text_timeline_duration ." for contract: ". $request->contract_name;
                    $variation_id = $id;
                    $type = 11;
                    $url = "/variations/" . $model_id;
                    $record_id = $model_id;
                    $contract_id = $variation['contract_id'];
                    $this->new_timeline($text, $variation_id, $type, $url, $record_id, $model_id, $contract_id);

                    // return back()-> with(["message" => "saved", "label" =>"info"]);
                    return redirect()->route('variations.index');
          }

        }else {
          // return redirect()->route('contracts.timeline', [$request->contract_id]);
          return back()-> with(["message" => "Nothing changed", "label" =>"warning"]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Variations  $variations
     * @return \Illuminate\Http\Response
     */
    public function destroy(Variations $variations)
    {
        //
    }

    public function variation_create($id)
    {
      $permission = "Create Variations";
      if(auth()->user()->can($permission) != true)
      {
          abort(403);
      }
        // getting contract details;
        $contract = contracts::select('id', 'currency as currency_id','contract_no','name','task_id','amount','base_curr_eqv','contractor','date','duration','status')
            ->with('currency')
            ->with('task.task_budget')
            ->find($id);

            $base_currency = $this->base_currency();
            $other_contracts = $this->other_contracts($contract['task_id']);
            $contracts_id = $this->id_to_array($other_contracts);
            $variations = $this->get_variations($contracts_id);
            $variation_otp = env('variation_otp');
            $effective_variation_amount = Variations::select('id','base_curr_eqv','status')
                ->whereIn('contract_id',$contracts_id)
                ->where('status',4)
                ->get()->sum('base_curr_eqv');

            // return $effective_variation_amount;

            return view('procurements.create_variation', compact
              (
                'contract',
                'base_currency',
                'other_contracts',
                'variations',
                'effective_variation_amount',
                'variation_otp'
              ));
    }

    public function variation_timeline($id)
    {
      $permission = "View Variations";
      if(auth()->user()->can($permission) != true)
      {
        abort(403);
      }

      //getting contrat ID
      $this_variation = Variations::with('timeline')
        ->with('contract:id,task_id','contract.task:id,text','contract.task.budget:id,task_id,budget')
        ->with('contract:id,currency as currency_id,task_id,name,duration','contract.currency:id,code')
        ->find($id);

      $contract = $this_variation['contract'];
      $base_currency = $this->base_currency();
      $other_contracts = $this->other_contracts($contract['task_id']);
      $contracts_id = $this->id_to_array($other_contracts);
      $variations = $this->get_variations($contracts_id);
      $timelines = $this->get_timeline_by_variation_id($id);
      $matrix = $this->get_matrix(1,$id);
      $variation_otp = env('variation_otp');

      $reject_comments = ApprovalComments::select('id','comment','type_id','level_id')
          ->where('matrix_id',$matrix['id'])
          ->get();

      // return $matrix;
      return view('procurements.variation_timeline', compact
        (
            'contract',
            'this_variation',
            'base_currency',
            'other_contracts',
            'variations',
            'timelines',
            'matrix',
            'reject_comments',
            'variation_otp'
          ));
    }

    public function reject(Request $request)
    {

      $matrix = $this->get_matrix(1,$request->id);
      $variation = Variations::select('id','contract_id')
          ->where('id',$request->id)
          ->with('contract:id,name')
          ->first();

      switch($request->level)
      {
                case 1:
                  $permission = "Verify Variations";
                  if(auth()->user()->can($permission) != true)
                  {
                    abort(403);
                  }

                  $matrix->varification_status = 0;
                  $matrix->varification_id = Auth::id();
                  $matrix->status = 0;
                  $matrix->save();

                  $comment = $this->new_approval_comment($matrix['id'], $request->level,$matrix->status,$request->comment);

                  $text = "Variation for contract: ". $variation['contract']['name']. " verification rejected";
                  $variation_id = $request->id;
                  $type = 11;
                  $url = "/variations/" . $request->id;
                  $record_id = null;
                  $model_id = null;
                  $contract_id = $variation['contract']['id'];
                  $timeline = $this->new_timeline($text, $variation_id, $type, $url, $record_id, $model_id, $contract_id);

                  $variation->status = 0;
                  $variation->save();
                  return redirect()->route('variation.timeline', [$variation->id])->with(['message' => "Reject Successful", 'label' => "success"]);
                break;

                case 2:
                  $permission = "Approve Variations";
                  if(auth()->user()->can($permission) != true)
                  {
                    abort(403);
                  }

                  $matrix->approval_status = 0;
                  $matrix->approval_id = Auth::id();
                  $matrix->status = 0;
                  $matrix->save();

                  $comment = $this->new_approval_comment($matrix['id'], $request->level,$matrix->status,$request->comment);

                  $text = "Variation for contract: ". $variation['contract']['name']. " Approval rejected";
                  $variation_id = $request->id;
                  $type = 11;
                  $url = "/variations/" . $request->id;
                  $record_id = null;
                  $model_id = null;
                  $contract_id = $variation['contract']['id'];
                  $timeline = $this->new_timeline($text, $variation_id, $type, $url, $record_id, $model_id, $contract_id);

                  $variation->status = 0;
                  $variation->save();

                  return redirect()->route('variation.timeline', [$variation->id])->with(['message' => "Reject Successful", 'label' => "success"]);
                  break;
                case 3:
                  $permission = "Authorize Variations";
                  if(auth()->user()->can($permission) != true)
                  {
                    abort(403);
                  }
                  $matrix->authorize_status = 0;
                  $matrix->authorize_id = Auth::id();
                  $matrix->status = 0;
                  $matrix->save();

                  $comment = $this->new_approval_comment($matrix['id'], $request->level,$matrix->status,$request->comment);

                  $text = "Variation for contract: ". $variation['contract']['name']. " Authorization rejected";
                  $variation_id = $request->id;
                  $type = 11;
                  $url = "/variations/" . $request->id;
                  $record_id = null;
                  $model_id = null;
                  $contract_id = $variation['contract']['id'];
                  $timeline = $this->new_timeline($text, $variation_id, $type, $url, $record_id, $model_id, $contract_id);

                  $variation->status = 0;
                  $variation->save();

                  return redirect()->route('variation.timeline', [$variation->id])->with(['message' => "Reject Successful", 'label' => "success"]);
                  break;
      }


      // return $timeline;
    }

    public function verify(Request $request)
    {
        $permission = "Verify Variations";
        if(auth()->user()->can($permission) != true)
        {
          abort(403);
        }

        $matrix = $this->get_matrix(1,$request->id);
        $variation = Variations::select('id','contract_id','variation_amount')
            ->where('id',$request->id)
            ->with('contract:id,name,currency as currency_id','contract.currency:id,xrate')
            ->first();

        $matrix->varification_status = 2;
        $matrix->varification_id = Auth::id();
        $matrix->status = 2;
        $matrix->save();

        $text = "Variation for contract: ". $variation['contract']['name']. " verified";
        $variation_id = $request->id;
        $type = 11;
        $url = "/variations/" . $request->id;
        $record_id = null;
        $model_id = null;
        $contract_id = $variation['contract']['id'];
        $timeline = $this->new_timeline($text, $variation_id, $type, $url, $record_id, $model_id, $contract_id);

        if($matrix['approval_check'] == 0 and $matrix['authorize_check']==0)
        {
              $variation->status = 4;
              $variation->base_curr_eqv = round($variation->variation_amount/$variation['contract']['currency']['xrate'],2) ?? 0;
              }else {
                $variation->status = 2;
        }

        $variation->save();


        // return $variation;
        return redirect()->route('variation.timeline', [$variation->id])->with(['message' => "Verified", 'label' => "success"]);
    }
    public function approve_otp(Request $request)
    {
      //get exising otp
      $variation_id = $request->id;
      $current_otp = Auth::user()->otp;

      $otp = Otp::expiry(5)->generate(Auth::user()->id . "approve" . $request->id);
      // $otp = Hash::make('$otp');
      if($current_otp != $otp)
      {
            Auth::user()->otp = $otp;
            Auth::user()->save();
            event(new OtpToken(Auth::user()));
            }else {
                    return view('procurements.approve_variation', compact('variation_id'))->with(['message' => "OTP Token Mismach", 'label' => "danger"]);;
      }
      return view('procurements.approve_variation', compact('variation_id'));
    }

    public function approve(Request $request)
    {
        $permission = "Approve Variations";
        if(auth()->user()->can($permission) != true)
        {
          abort(403);
        }

        $variation_otp = env('variation_otp');
        if($variation_otp == 1)
        {
            $valid = Otp::expiry(5)->match($request->otp, Auth::user()->id . "approve" . $request->id);
            }else {
              $valid = true;
        }

        if($variation_otp == 0 or ($variation_otp == 1 and $valid == true))
        {
                $matrix = $this->get_matrix(1,$request->id);
                $variation = Variations::select('id','contract_id','variation_amount')
                    ->where('id',$request->id)
                    ->with('contract:id,name,currency as currency_id','contract.currency:id,xrate')
                    ->first();

                $matrix->approval_status = 2;
                $matrix->approval_id = Auth::id();
                $matrix->status = 3;
                $matrix->save();

                $text = "Variation for contract: ". $variation['contract']['name']. " approved";
                $variation_id = $request->id;
                $type = 11;
                $url = "/variations/" . $request->id;
                $record_id = null;
                $model_id = null;
                $contract_id = $variation['contract']['id'];
                $timeline = $this->new_timeline($text, $variation_id, $type, $url, $record_id, $model_id, $contract_id);

                if($matrix['authorize_check']==0)
                {
                      $variation->status = 4;
                      $variation->base_curr_eqv = round($variation->variation_amount/$variation['contract']['currency']['xrate'],2) ?? 0;
                      }else {
                        $variation->status = 3;
                }
                $variation->save();
          }

        // return $matrix;
        if($valid == false)
        {
            return redirect()->route('variation.timeline', [$request->id])->with(['message' => "OTP Token Mismach", 'label' => "danger"]);
            }else {
                    return redirect()->route('variation.timeline', [$request->id])->with(['message' => "Approved", 'label' => "success"]);
        }

    }
    public function authorize_variation_otp(Request $request)
    {
      //get exising otp
      $variation_id = $request->id;
      $current_otp = Auth::user()->otp;

      $otp = Otp::expiry(5)->generate(Auth::user()->id . "authorize"  . $request->id);
      // $otp = Hash::make('$otp');
      if($current_otp != $otp)
      {
            Auth::user()->otp = $otp;
            Auth::user()->save();
            event(new OtpToken(Auth::user()));
            }else {
                    return view('procurements.authorize_variation', compact('variation_id'))->with(['message' => "OTP Token Mismach", 'label' => "danger"]);;
      }
      return view('procurements.authorize_variation', compact('variation_id'));
    }

    public function authorize_variation(Request $request)
    {
        $permission = "Authorize Variations";
        if(auth()->user()->can($permission) != true)
        {
          abort(403);
        }

        $variation_otp = env('variation_otp');
        if($variation_otp == 1)
        {
            $valid = Otp::expiry(5)->match($request->otp, Auth::user()->id . "authorize" . $request->id);
            }else {
              $valid = true;
        }

        if($variation_otp == 0 or ($variation_otp == 1 and $valid == true))
        {

              $matrix = $this->get_matrix(1,$request->id);
              $variation = Variations::select('id','contract_id','variation_amount')
                  ->where('id',$request->id)
                  ->with('contract:id,name,currency as currency_id','contract.currency:id,xrate')
                  ->first();

              $matrix->authorize_status = 2;
              $matrix->authorize_id = Auth::id();
              $matrix->status = 4;
              $matrix->save();

              $text = "Variation for contract: ". $variation['contract']['name']. " authorized";
              $variation_id = $request->id;
              $type = 11;
              $url = "/variations/" . $request->id;
              $record_id = null;
              $model_id = null;
              $contract_id = $variation['contract']['id'];
              $timeline = $this->new_timeline($text, $variation_id, $type, $url, $record_id, $model_id, $contract_id);

              $variation->status = 4;
              $variation->base_curr_eqv = round($variation->variation_amount/$variation['contract']['currency']['xrate'],2) ?? 0;
              $variation->save();
              // return $matrix;
        }

        if($valid == false)
        {
            return redirect()->route('variation.timeline', [$request->id])->with(['message' => "OTP Token Mismach", 'label' => "danger"]);
            }else {
                    return redirect()->route('variation.timeline', [$request->id])->with(['message' => "Authorized", 'label' => "success"]);
        }
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

    private function new_timeline($text, $variation_id, $type, $url, $record_id, $model_id, $contract_id)
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

      $new_timeline->save();

      return response()->json($new_timeline);
    }

    private function base_currency()
    {
      $base_currency_id = env('base_currency_id');
      return Currency::find($base_currency_id);
    }
    private function other_contracts($task_id)
    {
      return contracts::select('id','amount', 'date','duration','name','currency as currency_id','task_id','base_curr_eqv')
          ->where('task_id',$task_id)
          ->with('task:id,text', 'task.budget:id,task_id,budget')
          ->with('currency:id,code,xrate')
          ->get();
    }
    private function id_to_array($array)
    {
      foreach($array as $data)
      {
        $id [] = $data->id;
      }
      return $id;
    }
    private function get_variations($id)
    {
      return Variations::select('id','contract_id','variation_amount','status','id as record_id')
            ->whereIn('contract_id',$id)
            ->whereIn('status',[1,2,3])
            ->with('contract:id,currency as currency_id', 'contract.currency:id,xrate,code')
            ->with('timeline:record_id,id,text,type')
            ->get();
    }

    private function get_timeline_by_record_id($record_id)
    {
      return Timeline::select('text','task','user as user_id','type','updated_at','record_id')
          ->whereIn('type',[11,12])
          ->where('record_id',$record_id)
          ->with('user:id,name')
          ->orderBy('updated_at', 'DESC')
          ->get();
    }
    private function get_timeline($task_id)
    {
      return Timeline::select('text','task','user as user_id','type','updated_at','record_id')
          ->whereIn('type',[10,11])
          ->where('task',$task_id)
          ->with('user:id,name')
          ->orderBy('updated_at', 'DESC')
          ->get();
    }
    private function get_timeline_by_variation_id($id)
    {
      return Timeline::select('text','task','user as user_id','type','updated_at','record_id')
          ->whereIn('type',[11,12])
          ->where('variation_id',$id)
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
