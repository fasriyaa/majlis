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


use Illuminate\Http\Request;

use Auth;

class VariationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        //checking for changes;
        $contract = contracts::select('id','amount','duration','name','task_id')
            ->where('id',$request->contract_id)
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

                  $variation->contract_id = $request->contract_id;
                  $variation->variation_amount = $amount;
                  $variation->variation_duration = $duration;
                  $variation->status = 1;
                  $variation->save();

                    //recording in approval matrix
                      $varification_check = env('variation_varification_check');
                      $approval_check = env('variation_approval_check');
                      $authorization_check = env('variation_authorization_check');

                      $model = 1;
                      $model_id = $variation->id;

                      $this->new_approval_matrix($model, $model_id, $varification_check, $approval_check, $authorization_check);

                    //recording into timeline
                    $text = "Variation to change: contract amount " . $text_timeline_amount . "; and/or contract duration " . $text_timeline_duration ." for contract: ". $contract['name'];
                    $task = $contract['id'];
                    $type = 11;
                    $url = "/variations/" . $model_id;
                    $record_id = $model_id;
                    $this->new_timeline($text, $task, $type, $url, $record_id);

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
    public function edit(Variations $variations)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Variations  $variations
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Variations $variations)
    {
        //
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
      // getting contract details;
      $contract = contracts::select('id','amount', 'date','duration','name','currency as currency_id','task_id','base_curr_eqv')
          ->where('id',$id)
          ->with('task:id,text', 'task.budget:id,task_id,budget')
          ->with('currency:id,code')
          ->first();

          $base_currency_id = env('base_currency_id');
          $base_currency = Currency::find($base_currency_id);

          //get other contracts linked to the task
          $other_contracts = contracts::select('id','amount', 'date','duration','name','currency as currency_id','task_id','base_curr_eqv')
              ->where('task_id',$contract['task_id'])
              ->with('task:id,text', 'task.budget:id,task_id,budget')
              ->with('currency:id,code,xrate')
              ->get();

          //getting pending variations
            foreach($other_contracts as $other_contract)
            {
              $contracts_id [] = $other_contract->id;
            }

            $variations = Variations::select('id','contract_id','variation_amount','status','id as record_id')
                  ->whereIn('contract_id',$contracts_id)
                  ->where('status',1)
                  ->with('contract:id,currency as currency_id', 'contract.currency:id,xrate,code')
                  ->with('timeline:record_id,id,text,type')
                  ->get();


      // return $other_contracts;
      return view('procurements.create_variation', compact('contract','base_currency','other_contracts','variations'));
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

    private function new_timeline($text, $task, $type, $url, $record_id)
    {
      $user_id = Auth::id();

      $new_timeline = new Timeline;

      $new_timeline->text = $text;
      $new_timeline->task = $task ?? null;
      $new_timeline->user = $user_id;
      $new_timeline->type = $type;
      $new_timeline->url = $url ?? null;
      $new_timeline->record_id = $record_id ?? null;

      $new_timeline->save();

      return response()->json($new_timeline);
    }


}
