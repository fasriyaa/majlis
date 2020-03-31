<?php
namespace App\Http\Controllers\Budget;

use App\Http\Controllers\Controller;

use App\models\budget\PV;
use App\models\budget\Invoice;
use App\models\timeline\Timeline;

use Illuminate\Http\Request;

use Auth;

class PVController extends Controller
{

    public function index()
    {
      $permission = "View PV";
      if(auth()->user()->can($permission) == false)
      {
          abort(403);
      }

        $pvs = PV::select('id','pv_no','date','details', 'id as pv_id')
            ->with('invoice.contract.currencies')
            ->get();

        // return $pvs;
        return view('budget.pv.index', compact('pvs'));
    }
    public function create()
    {

      $permission = "Create PV";
      if(auth()->user()->can($permission) == false)
      {
          abort(403);
      }

        //getting all unsettled invoices
        $invoices = Invoice::select('id','invoice_no','contract_id')
            ->where('status',4)
            ->where('pv_id', null)
            ->with('contract:id,contract_no,contractor')
            ->get();
        // return $invoices;
        return view('budget.pv.create',compact('invoices'));
    }
    public function store(Request $request)
    {
      $model_id = 5;
      $permission = "Create PV";
      if(auth()->user()->can($permission) == false)
      {
          abort(403);
      }

      //check if PV No. exist;
      $x_record = PV::select('pv_no')
          ->where('pv_no',$request->pv_no)
          ->first();
      if($x_record)
      {
        abort(400);
      }


      //recording new PV
      $new_pv = new PV;
      $new_pv->pv_no = $request->pv_no;
      $new_pv->details = $request->details;
      $new_pv->date = date('Y-m-d',strtotime($request->date));
      $new_pv->save();

      //updating the invoice table with pv_id;
      $invoice = Invoice::find($request->invoice_no);
        if($invoice->status != 4)
        {
          abort(400);
        }
      $invoice->pv_id = $new_pv->id;
      $invoice->status = 5;
      $invoice->save();

      //recording timeline entry
      $text = "New PV entered for invoice: ". $invoice->invoice_no;
      $variation_id = null;
      $type = 13;
      $url = "/pv/".$new_pv->id;
      $record_id = $new_pv->id;
      $contract_id = $invoice->contract_id;
      $event_id = $new_pv->id;
      $new_timeline = $this->new_timeline($text, $variation_id, $type, $url, $record_id, $model_id, $contract_id, $event_id);

      return redirect()->route('pv.index');
    }
    public function show(PV $pV)
    {
        //
    }
    public function edit(PV $pV)
    {
        //
    }
    public function update(Request $request, PV $pV)
    {
        //
    }
    public function destroy(PV $pV)
    {
        //
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
}
