<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostPublic;

class PostPublicController extends Controller
{
    public function store(Request $request)
    {
        $attrs = $request -> validate([
            'plantname' => 'required|string',
            'body' => 'required|string'
        ]);

        $post = PostPublic::create([
            'plantname' => $attrs['plantname'],
            'body' => $attrs['body']
        ]);

        return response([
            'message' => "Post created",
            'post' => $post
        ], 200);
    }

    public function index(Request $request)
    {
        $posts = PostPublic::all();
        
        return response([
            'message' => "Post retrieved",
            'post' => $posts
        ], 200);
    }

    public function show(Request $request, $id){
       // $postshow = PostPublic::find($id);

        return response([
            'message' => 'Post Found',
            'post' => PostPublic::where('id', $id)->get()
        ], 200);

    }

    public function update(Request $request, $id){
        $attrs = $request -> validate([
            'plantname' => 'nullable|string',
            'body' => 'nullable|string'
        ]);
        
        $postshow = PostPublic::find($id);
        if($postshow){
            $postshow->update($attrs);

            return response()-> json([
                'message' => 'Post Updated',
                'post' => $postshow
            ], 200);
        }else{
            return response()->json([
                'message' => 'Post Not Found',
                'post' => null
            ], 404);
        }
    }

    public function delete(Request $request, $id){
        
        $postdel = PostPublic::find($id);
        
        if($postdel){
            $postdel->delete();

            return response()-> json([
                'message' => 'Post Deleted',
                'post' => null
            ], 200);
        }else{
            return response()->json([
                'message' => 'Post Not Found',
                'post' => null
            ], 404);
        }
    }
}
