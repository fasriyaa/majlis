<?php
namespace App\Http\Controllers\Gantt;

use App\Http\Controllers\Controller;

use App\models\gantt\Task;
use App\models\gantt\Link;

class GanttController extends Controller
{
    public function get(){
        $tasks = new Task();
        $links = new Link();

        return response()->json([
            "data" => $tasks->orderBy('sortorder')->get(),
            "links" => $links->all()
        ]);
    }

    public function get_selected($id){
        $tasks = new Task();
        $links = new Link();

        return response()->json([
            "data" => $tasks->orderBy('sortorder')->get(),
            "links" => $links->all()
        ]);
    }


}
