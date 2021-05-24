<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        return response()->json([

            'status' => 200,
            'data'   => Post::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\PostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {

        if (! Gate::allows('isWrite', request()->user())) {
            return response()->json([
                'status' => 403,
                'data'   => "You dont have permission to write post!"
            ]);
        }

        $post = Post::create( array_merge(
            
            $request->all(), 
            ['user_id' => $request->user()->id]
        ));
        
        return response()->json([
            
            'status'    => 200,
            'post_id'   => $post->id
            ]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show( Post $post )
    {
        return response()->json([

            'status' => 200,
            'post'   => $post
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\PostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {        
        if (! Gate::allows('isEdit', request()->user(), $post)) {
            return response()->json([
                'status' => 403,
                'data'   => "You dont have permission to Edit this post!"
            ]);
        }

        $params = $request->all();
        $post->update($params);

        return response()->json([

            'status'    => 200,
            'post'   => $post
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if (! Gate::allows('isDelete', request()->user())) {
            return response()->json([
                'status' => 403,
                'data'   => "Only Admin has permission to Delete posts!"
            ]);
        }
        $post->delete();
        return response()->json([

            'status'    => 200,
            'post_id'   => $post->id
        ]);   


    }
}
