<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Mail\Subscribers;
use App\Models\Post;
use App\Models\Subscribe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get all the posts
        $posts = Post::latest()->get();
        // return response
        return response()->json(['posts' => $posts, 'message' => '', 200]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        // validation
        $validation = Validator::make($data, [
            'website_name' => 'required|exists:websites,name',
            'title' => 'required',
            'description' => 'required'
        ]);

        if ($validation->fails()) {
            //return fail response message
            return response()->json(['post'=> [], 'message'=> $validation->errors(), 200]);
        }else{
            // create the post
            $post = Post::firstOrCreate($data);
            // get subscribers
            $subscribers = Subscribe::where('website_name', $data['website_name'])->get();
            $details = [
                'title' => $data['title'],
                'description' => $data['description'],
            ];

            foreach($subscribers as $subscriber){
                Mail::to($subscriber)->queue(new Subscribers($details));
            }
            // return Response
            return response()->json(['post'=> $post, 'message'=>['Post Created.'], 200]);
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
        // find post by id
        $post = Post::find($id);
        // return response
        return response()->json(['post'=> $post, 'message'=>[], 200]);
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
        // find post
        $post = Post::find($id);
         // validation
         $validation = Validator::make($data, [
            'website_name' => 'required|exists:websites,name',
            'title' => 'required',
            'description' => 'required'
        ]);

        if ($validation->fails()) {
            //return fail response message
            return response()->json(['post'=> [], 'message'=> $validation->errors(), 200]);
        }else{
            // update post
            $post = $post->update($data);
            // return Response
            return response()->json(['post'=> $post, 'message'=>['Post Updated.'], 200]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //softdelete the post
        $post->delete();
        // return Response
        return response()->json(['post'=> $post, 'message'=>['Post Deleted.'], 200]);

    }
}
