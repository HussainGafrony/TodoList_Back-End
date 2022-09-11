<?php

namespace App\Http\Controllers;

use App\Models\Item;
// use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Item::orderby('created_at', 'DESC')->get();
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
        $newItem = new Item;
        $newItem->name = $request->name;
        $newItem->save();

        return $newItem;
    }

    public function update(Request $request, $id)
    {
        $existingItem = Item::find($id);
        if ($existingItem) {
            // $existingItem->name = $request->name ?  $request->name :$existingItem->name;
            $existingItem->completed = $request->completed ? true : false;
            $existingItem->completed_at = $request->completed_at ? Carbon::now() : null;
            $existingItem->save();
            return $existingItem;
        }
        return response()->json(['status'=>'item not found.'],404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $existingItem = Item::find($id);
        if($existingItem)
        {
            $existingItem->delete();
            return response()->json(['status'=>'item successfully deleted'],200);
        }        
        return response()->json(['status'=>'item not found.'],404);
    }
}
