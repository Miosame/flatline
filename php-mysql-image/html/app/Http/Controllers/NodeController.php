<?php

namespace App\Http\Controllers;

use App\Node;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nodes = Node::orderBy('online', 'desc')
                    ->orderBy(DB::raw('ISNULL(comment), comment'), 'asc')
                    ->orderBy(DB::raw('ISNULL(hostname), hostname'), 'asc')
                    ->get();
                    
        $online = Node::where('online', 1)->count();
        $offline = Node::where('online', 0)->count();
        return view('index',compact('nodes','online','offline'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Node  $node
     * @return \Illuminate\Http\Response
     */
    public function edit(Node $node)
    {
        return view('edit',compact('node'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Node  $node
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Node $node)
    {
        $node->comment = $request->input("hostname");
        $node->save();
        return redirect()->route('nodes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Node  $node
     * @return \Illuminate\Http\Response
     */
    public function destroy(Node $node)
    {
        //
    }
}
