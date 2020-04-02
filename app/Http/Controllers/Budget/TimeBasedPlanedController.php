<?php

namespace App\Http\Controllers\Budget;

use App\Http\Controllers\Controller;

use App\models\budget\TimeBasedPlaned;
use App\models\budget\TimeBaseActual;
use App\models\procurement\contracts;
use App\models\currency\Currency;
use App\models\budget\Invoice;

use Illuminate\Http\Request;
use Auth;

class TimeBasedPlanedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        $permission = "Create Timebaseplan";
        if(auth()->user()->can($permission) == false)
        {
            abort(403);
        }

        //check for existing
        $xrecord = TimeBasedPlaned::where('contract_id',$request->contract_id)
            ->first();
        if($xrecord)
        {
          abort(400);
        }

        $new_timebaseplan = new TimeBasedPlaned;
        $new_timebaseplan->contract_id = $request->contract_id;
        $new_timebaseplan->rem_days = $request->rem_days;
        $new_timebaseplan->rem_rate = $request->rem_rate;
        $new_timebaseplan->perdiem_days = $request->perdiem_days ?? null;
        $new_timebaseplan->perdiem_rate = $request->perdiem_rate ?? null;
        $new_timebaseplan->trip_days = $request->trip_days ?? null;
        $new_timebaseplan->trip_rate = $request->trip_rate ?? null;
        $new_timebaseplan->transfer_days = $request->transfer_days ?? null;
        $new_timebaseplan->transfer_rate = $request->transfer_rate ?? null;
        $new_timebaseplan->save();

        //updating the contract id
        $contract = $this->get_contract_byId($request->contract_id);
        $contract->time_based = $new_timebaseplan->id;
        $contract->save();

        // return $new_timebaseplan;
        return redirect()->route('contracts.timeline',[$request->contract_id])->with(['message' => "Timebase Plan Created", 'label' => "success"]);
    }
    public function show(TimeBasedPlaned $timeBasedPlaned)
    {
        //
    }
    public function edit($id)
    {
      $permission = "Edit Timebaseplan";
      if(auth()->user()->can($permission) == false)
      {
          abort(403);
      }
      $timebaseplan = TimeBasedPlaned::find($id);

      $contract = $this->get_contract_byId($timebaseplan->contract_id);
      $base_currency = $this->get_base_currency();
      return view('budget.timebase.edit', compact('contract','base_currency','timebaseplan'));
    }
    public function update(Request $request)
    {
      $permission = "Edit Timebaseplan";
      if(auth()->user()->can($permission) == false)
      {
          abort(403);
      }

      $timebaseplan = TimeBasedPlaned::find($request->id);

      $timebaseplan->rem_days = $request->rem_days;
      $timebaseplan->rem_rate = $request->rem_rate;
      $timebaseplan->perdiem_days = $request->perdiem_days;
      $timebaseplan->perdiem_rate = $request->perdiem_rate;
      $timebaseplan->trip_days = $request->trip_days;
      $timebaseplan->trip_rate = $request->trip_rate;
      $timebaseplan->transfer_days = $request->transfer_days;
      $timebaseplan->transfer_rate = $request->transfer_rate;
      $timebaseplan->save();

        return redirect()->route('timebaseplaned.sheet',[$timebaseplan->contract_id]);
    }
    public function destroy(TimeBasedPlaned $timeBasedPlaned)
    {
        //
    }

    public function new_timebased_planed($id)
    {
          $permission = "Create Timebaseplan";
          if(auth()->user()->can($permission) == false)
          {
              abort(403);
          }

          $contract = $this->get_contract_byId($id);
          $base_currency = $this->get_base_currency();
          return view('budget.timebase.create', compact('contract','base_currency'));
    }
    public function sheet($id)
    {
        $permission = "View Timebaseplan";
        if(auth()->user()->can($permission) == false)
        {
            abort(403);
        }
        $timebaseplan = $this->get_timebaseplan_by_contractId($id);

        //getting timebase actuals
            //get list of all invoices;
            $invoices_id = Invoice::where('contract_id',$id)
                ->pluck('id');

            $timebase_actuals = TimeBaseActual::whereIn('invoice_id',$invoices_id)
              ->with('invoice:id,invoice_no,invoice_date')
              ->get();

        // return $timebase_actuals;
        $contract = $this->get_contract_byId($id);
        $base_currency = $this->get_base_currency();

        // return $contract;
        return view('budget.timebase.sheet',compact('timebaseplan','contract','base_currency','timebase_actuals'));

    }


    private function get_contract_byId($id)
    {
      return contracts::select('id','contract_no','name','amount','contractor','duration','currency','time_based')
          ->with('variations')
          ->with('currencies')
          ->where('id', $id)
          ->first();
    }
    private function get_base_currency()
    {
      return Currency::find(env('base_currency_id'));
    }
    private function get_timebaseplan_by_contractId($id)
    {
      return TimeBasedPlaned::where('contract_id',$id)
          ->first();
    }
}
