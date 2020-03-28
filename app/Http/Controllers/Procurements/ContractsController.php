<?php

namespace App\Http\Controllers\Procurements;

use App\Http\Controllers\Controller;

use App\models\procurement\contracts;
use App\models\procurement\ContractTypes;
use App\models\timeline\Timeline;
use App\models\docs\RequireDoc;
use App\models\gantt\Task;
use App\models\procurement\Variations;
use App\models\currency\Currency;
use App\models\auth\ApprovalMatrix;

use Illuminate\Http\Request;

use Illuminate\Http\UploadedFile;
use App\Http\Controllers\Traits\FileUploadTrait;

use Auth;
use View;

class ContractsController extends Controller
{

  use FileUploadTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $permission = "View Contracts";
      $err_url = "layouts.exceptions.403";
      if(auth()->user()->can($permission) == true)
      {
        //get all contracts
        $contracts = contracts::select('id','name','type as type_id','contract_no','task_id','currency','amount','contractor','date','duration','status')
            ->with('type:id,name as type_name')
            ->get();

        // return $contracts;
        return view('procurements.contracts',compact('contracts'));
            }else {
              return view($err_url);
      }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $permission = "Create Contracts";
      $err_url = "layouts.exceptions.403";
      if(auth()->user()->can($permission) == true)
      {
        //gertting Contract Types
        $contract_types = ContractTypes::select('id','name')
            ->where('status',1)
            ->get();

        return view('procurements.create_contract',compact('contract_types'));
          }else {
            return view($err_url);
      }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      $permission = "Create Contracts";
      $err_url = "layouts.exceptions.403";
      if(auth()->user()->can($permission) == true)
      {
        $contract = new contracts;

        $contract->type = $request->type;
        $contract->contract_no = $request->contract_no;
        $contract->name = $request->name;
        $contract->currency = $request->currency;
        $contract->amount = $request->amount;

            $base_currency_id = env('base_currency_id');
            $contract_currency = Currency::select('id','code','xrate')
              ->where('id',$request->currency)
              ->first();

            if($base_currency_id ==$contract_currency['id'])
            {
                  $contract->base_curr_eqv = $request->amount;
                  }else {
                          $contract->base_curr_eqv = round($request->amount/$contract_currency['xrate'],2);
            }

        $contract->contractor = $request->contractor;
        $contract->date = date('Y-m-d',strtotime($request->contract_date));
        $contract->duration = $request->duration;
        $contract->status = 1;
        $contract->task_id = $request->task_id ?? null;

        $contract->save();

        //create timeline record
        $text = "New contract created. Contract name: ". $contract->name;
        $contract_id = $contract->id;
        $type = 10;
        $url = "/contracts/timeline/". $contract->id;
        $model_id = 2;
        $record_id = $contract->id;
        $this->new_timeline($text, $contract_id, $type, $url,$model_id,$record_id);

        // return $contract;
        return redirect()->route('contracts.index');
        // return redirect()->route('user.profile', ['step' => $step, 'id' => $id]);
          }else {
            return view($err_url);
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\contracts  $contracts
     * @return \Illuminate\Http\Response
     */
    public function show(contracts $contracts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\contracts  $contracts
     * @return \Illuminate\Http\Response
     */
    public function edit(contracts $contracts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\contracts  $contracts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, contracts $contracts)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\contracts  $contracts
     * @return \Illuminate\Http\Response
     */
    public function destroy(contracts $contracts)
    {
        //
    }

    public function timeline($id)
    {
      $permission = "View Contracts";
      $err_url = "layouts.exceptions.403";
      if(auth()->user()->can($permission) == true)
      {
        $contract = contracts::select('id','contract_no','name','task_id')
            ->with('task:id,text,progress')
            ->find($id);

        //retriving timeline records
        $timelines = Timeline::select('text','task','user as user_id','type','updated_at','record_id')
            ->where('contract_id',$id)
            ->with('user:id,name')
            ->orderBy('updated_at', 'DESC')
            ->get();

        $docs = RequireDoc::select('doc_date','alias_name','doc_name')
            ->where('req_doc_type',4)
            ->where('task_id',$id)
            ->get();


        //getting all tasks
            // Getting Main component ID
            $main_id = Task::where('parent', '=', 1)
                ->pluck('id');

            $sub_id = Task::whereIn('parent', $main_id)
                ->pluck('id');

            $act_id = Task::whereIn('parent', $sub_id)
                ->pluck('id');

            $subact_id = Task::whereIn('parent', $act_id)
                ->pluck('id');

            $tasks = Task::select('id', 'text')
                ->whereIn('parent', $subact_id)
                ->get();
          //getting all tasks end

          //getting variations;
          $variations = Variations::select('id', 'contract_id', 'status', 'id as record_id','id as model_id')
              ->where('contract_id', $id)
              ->with('timeline:record_id,id,text,type')
              ->with('matrix')
              ->get();

        $doc_count = count($docs);
        $contract_count = count($docs);




        // return $variations;
        return view('procurements.contract_timeline', compact('contract','timelines','docs','doc_count','contract_count','tasks','variations'));
          }else {
            return view($err_url);
      }
    }

    public function upload_contracts(Request $request)
    {
      $permission = "Create Contracts";
      $err_url = "layouts.exceptions.403";
      if(auth()->user()->can($permission) == true)
      {
        $file_name = $request->file('file')->getClientOriginalName();
        $request = $this->saveFiles($request);

        //recording document details
        $task_id = $request->contract_id;
        $doc_name = $request->input('file');
        $status = 2;
        $req_doc_type = 4;
        $doc = contracts::select('date','name')
              ->where('id',$request->contract_id)
              ->first();
        $doc_date = date('Y-m-d',strtotime($doc['date']));
        $alias_name = "Signed Contract";

        $new_doc = $this->new_doc_record($task_id,$doc_name,$status,$req_doc_type,$doc_date,$alias_name);


        //create timeline record
        $contract_name = $doc['name'];
        $text = "Contract Uploaded for contract: ". $contract_name;
        $contract_id = $request->contract_id;
        $type = 10;
        $url = "/files/". $doc_name;
        $model_id = 3;
        $record_id =$new_doc->id;
        $this->new_timeline($text, $contract_id, $type, $url, $model_id, $record_id);

        // return $doc;
        return redirect()->route('contracts.timeline', [$request->contract_id]);
            }else {
              return view($err_url);
      }
    }

    public function upload_amendment(Request $request)
    {
      $permission = "Create Contracts";
      $err_url = "layouts.exceptions.403";
      if(auth()->user()->can($permission) == true)
      {
        $file_name = $request->file('file')->getClientOriginalName();
        $request = $this->saveFiles($request);

        //recording document details
        $task_id = $request->contract_id;
        $doc_name = $request->input('file');
        $status = 2;
        $req_doc_type = 4;
        $doc = contracts::select('date','name')
              ->where('id',$request->contract_id)
              ->first();
        $doc_date = date('Y-m-d',strtotime($doc['date']));
        $alias_name = $request->amendment;

        $new_doc = $this->new_doc_record($task_id,$doc_name,$status,$req_doc_type,$doc_date,$alias_name);


        //create timeline record
        $contract_name = $doc['name'];
        $text = "Contract amendment Uploaded for contract: ". $contract_name;
        $contract_id = $request->contract_id;
        $type = 10;
        $url = "/files/". $doc_name;
        $model_id = 3;
        $record_id = $new_doc->id;
        $this->new_timeline($text, $contract_id, $type, $url, $model_id, $record_id);


        // return $request;
        return redirect()->route('contracts.timeline', [$request->contract_id]);
          }else {
            return view($err_url);
      }
    }

    public function link_task(Request $request)
    {
      $permission = "Link Contract to a Task";
      $err_url = "layouts.exceptions.403";
      if(auth()->user()->can($permission) == true)
      {
        $contract = contracts::find($request->contract_id);
        $contract_amount = $contract['base_curr_eqv'];

        //getting task budget figure;
        $task = Task::select('id', 'text', 'id as task_id')
            ->where('id', $request->task_id)
            ->with('budget:id,task_id,budget')
            ->with('contracts:id,task_id,base_curr_eqv,name')
            ->first();
        $task_budget = $task['budget']['budget'];

        //getting commitments of the task
            //getting existing contracts
            $commitments = $contract['base_curr_eqv'];
            foreach($task['contracts'] as $contracts)
            {
              $commitments = $commitments + $contracts['base_curr_eqv'];
              $contract_id [] = $contracts['id'];
            }
            $contract_id [] = $request->contract_id;

            //getting all pending variations
            $variations = Variations::select('id','contract_id','variation_amount','status','id as record_id')
                  ->whereIn('contract_id',$contract_id)
                  ->where('status',1)
                  ->with('contract:id,currency as currency_id', 'contract.currency:id,xrate')
                  ->get();

            foreach($variations as $variation)
            {
                $commitments = $commitments + $variation['variation_amount']/$variation['contract']['currency']['xrate'];
            }

        if($task['budget']['budget'] < $commitments)
        {
          return back()-> with(["message" => "No sufficient budget", "label" =>"danger"]);
        }else {
              $contract->task_id = $request->task_id;
              $contract->save();
        }

        // return $commitments;
        return redirect()->route('contracts.timeline', [$request->contract_id]);
          }else {
            return view($err_url);
      }
    }

    public function link_tasks($id)
    {
      $permission = "Link Contract to a Task";
      $err_url = "layouts.exceptions.403";
      if(auth()->user()->can($permission) == true)
      {
        //getting contract details
        $contract = contracts::select('id', 'contract_no', 'name', 'currency as currency_id','amount','base_curr_eqv','contractor','date','duration','status')
            ->where('id',$id)
            ->with('currency:id,code,xrate')
            ->first();


        //getting all tasks
            // Getting Main component ID
            $main_id = Task::where('parent', '=', 1)
                ->pluck('id');

            $sub_id = Task::whereIn('parent', $main_id)
                ->pluck('id');

            $act_id = Task::whereIn('parent', $sub_id)
                ->pluck('id');

            $subact_id = Task::whereIn('parent', $act_id)
                ->pluck('id');

            $tasks = Task::select('id', 'text', 'id as task_id')
                ->whereIn('parent', $subact_id)
                ->with('budget:id,task_id,budget')
                ->with('contracts:id,task_id,base_curr_eqv,name')
                ->get();
          //getting all tasks end\



        $base_currency_id = env('base_currency_id');
        $base_currency = Currency::find($base_currency_id);
        $base_currency = $base_currency['code'];



        return view('Procurements.link_task', compact('tasks','contract','base_currency'));
          }else {
            return view($err_url);
      }
    }


    private function new_timeline($text, $contract_id, $type, $url, $model_id, $record_id)
    {
      $user_id = Auth::id();

      $new_timeline = new Timeline;

      $new_timeline->text = $text;
      $new_timeline->contract_id = $contract_id ?? null;
      $new_timeline->user = $user_id;
      $new_timeline->type = $type;
      $new_timeline->url = $url ?? null;
      $new_timeline->model_id = $model_id;
      $new_timeline->record_id = $record_id;

      $new_timeline->save();

      return response()->json($new_timeline);
    }

    private function new_doc_record($task_id,$doc_name,$status,$req_doc_type,$doc_date,$alias_name)
    {

      $up_doc = new RequireDoc;

      $up_doc->task_id = $task_id;
      $up_doc->doc_name = $doc_name;
      $up_doc->status = $status;
      $up_doc->req_doc_type = $req_doc_type;
      $up_doc->doc_date = $doc_date;
      $up_doc->alias_name = $alias_name;

      $up_doc->save();
      return $up_doc;
    }


    public function task_link_budget(Request $request)
    {
      $permission = "Link Contract to a Task";
      $err_url = "layouts.exceptions.403";
      if(auth()->user()->can($permission) == true)
      {
        //get budget
        $task = Task::select('id', 'text', 'id as task_id')
            ->where('id', $request->id)
            ->with('budget:id,task_id,budget')
            ->with('contracts:id,task_id,base_curr_eqv,name')
            ->first();


        $base_currency_id = env('base_currency_id');
        $base_currency = Currency::find($base_currency_id);
        $base_currency = $base_currency['code'];

        //get variations for the contract
          foreach($task['contracts'] as $contracts)
          {
            $contract_id [] = $contracts['id'];
          }
          $contract_id [] = $request->contract_id;

        $variations = Variations::select('id','contract_id','variation_amount','status','id as record_id')
              ->whereIn('contract_id',$contract_id)
              ->where('status',1)
              ->with('contract:id,currency as currency_id', 'contract.currency:id,xrate')
              ->with('timeline:record_id,id,text,type')
              ->get();


        // return $variations;
        return View::make("procurements/partials/task_link_budget", ["task" => $task, "base_currency" => $base_currency, "variations" => $variations]);
          }else {
            return view($err_url);
      }
    }
    private function get_matrix($model,$id)
    {
      return ApprovalMatrix::where('model',$model)
          ->where('model_id',$id)
          ->first();

    }


}
