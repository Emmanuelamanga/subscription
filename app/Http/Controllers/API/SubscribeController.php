<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Subscribe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscribeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //show all subscribers
        $subscribers = Subscribe::with('websites')->get();
        // return response
        return response()->json(['subscribers' => $subscribers, 'message' => [], 200]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //array of inputs
        $data = $request->all();
        // validation
        $validation = Validator::make($data, [
            'website_name' => 'required|exists:websites,name',
            'email' => 'required|email|unique:subscribes,email'
        ]);

        if ($validation->fails()) {
            //return fail response message
            return response()->json(['subscriber'=> [], 'message'=> $validation->errors(), 200]);
        }else{
            // create the subscriber
            $subscriber = Subscribe::firstOrCreate($data);
            // return Response
            return response()->json(['subscriber'=> $subscriber, 'message'=>['Thanks for joining out newsletter listing.'], 200]);
        }
        return response()->json();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // find subscriber by id
        $subscriber = Subscribe::find($id);
        // return response
        return response()->json(['subscriber'=> $subscriber, 'message'=>[], 200]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // array of request
        $data = $request->all();
        // find subscribe
        $subscribe = Subscribe::find($id);
         // validation
         $validation = Validator::make($data, [
            'website_name' => 'required|exists:websites,name',
            'email' => 'required|email|unique:subscribes,email'
         ]);

        if ($validation->fails()) {
            //return fail response message
            return response()->json(['subscribe'=> [], 'message'=> $validation->errors(), 200]);
        }else{
            // update subscribe
            $subscribe = $subscribe->update($data);
            // return Response
            return response()->json(['subscribe'=> $subscribe, 'message'=>['subscribe Updated.'], 200]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
