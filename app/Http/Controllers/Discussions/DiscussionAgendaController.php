<?php

namespace App\Http\Controllers\Discussions;

use App\Http\Controllers\Controller;
use App\models\discussions\DiscussionAgenda;
use Illuminate\Http\Request;

class DiscussionAgendaController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $agenda = new DiscussionAgenda;

        $agenda->description = $request->input('description');
        $agenda->submitter_type = $request->input('submitter_type');
        $agenda->submitter_id = $request->input('submitter_id');
        $agenda->discussion_id = $request->input('discussion_id');

        $agenda->save();

        // return $agenda;
        return redirect()->route('sc.view', [$request->input('discussion_id')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DiscussionAgenda  $discussionAgenda
     * @return \Illuminate\Http\Response
     */
    public function show(DiscussionAgenda $discussionAgenda)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DiscussionAgenda  $discussionAgenda
     * @return \Illuminate\Http\Response
     */
    public function edit(DiscussionAgenda $discussionAgenda)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DiscussionAgenda  $discussionAgenda
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DiscussionAgenda $discussionAgenda)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DiscussionAgenda  $discussionAgenda
     * @return \Illuminate\Http\Response
     */
    public function destroy(DiscussionAgenda $discussionAgenda)
    {
        //
    }
}
