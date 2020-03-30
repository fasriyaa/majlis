<?php

namespace App\Http\Controllers\Budget;

use App\Http\Controllers\Controller;

use App\models\budget\Invoice;
use App\models\procurement\contracts;
use Illuminate\Http\Request;

class InvoiceController extends Controller
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
      $permission = "Create Invoice";
      if(auth()->user()->can($permission) == false)
      {
          abort(403);
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

              //timeline record

              return redirect()->route('invoice_create',$request->contract_id)->with(['message' => "The invoice recorded", 'label' => "success"]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        //
    }

    public function create_invoice($id)
    {
      $permission = "Create Invoice";
      if(auth()->user()->can($permission) == false)
      {
          abort(403);
      }

      $contract = contracts::select('id','contract_no','name', 'currency as currency_id', 'amount', 'contractor','date','duration', 'id as contract_id')
          ->where('id',$id)
          ->with('currency:id,code')
          ->with('variations:id,contract_id,variation_amount,status')
          ->with('invoices:id,contract_id,amount,advanc_recovery,retention,status')
          ->first();

          // return $contract;
      return view('budget.invoice.create',compact('contract'));
    }
}
