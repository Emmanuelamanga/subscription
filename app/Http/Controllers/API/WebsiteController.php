<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         // get all the websites
         $websites = Website::latest()->get();
        //  return response
         return response()->json(['websites' => $websites, 'message' => [], 200]);
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
            'name' => 'required|unique:websites,name',
            'url' => 'required|unique:websites,url'
        ]);

        if ($validation->fails()) {
            //return fail response message
            return response()->json(['website'=> [], 'message'=> $validation->errors(), 200]);
        }else{
            // create the website
            $website = Website::firstOrCreate($data);
            // return Response
            return response()->json(['website'=> $website, 'message'=>['Website Created.'], 200]);
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
        //
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
        //
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
