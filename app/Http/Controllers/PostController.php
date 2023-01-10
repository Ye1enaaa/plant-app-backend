<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller{
    //get all post

    public function index()
    {
        return response([
            'posts' => Post::orderBy('created_at', 'desc')->with('user:id,name,image')->get()
        ], 200);
    }

    //get single post

    public function show($id)
    {
        return response([
            'post' => Post::where('id', $id)->get()
        ], 200);
    }

    //create post
    public function store(Request $request)
    {
        //validate fields
        $attrs = $request -> validate([
            'body' => 'required|string'
        ]);

        //$image = $this->saveImage($request->image, 'posts');

        $post = Post::create([
            'body'=> $attrs['body'],
            'user_id'=> auth()->user()->id, //error, null daw ang gi state
        ]);


        return response([
            'message' => 'Post created',
            'post' => $post,
        ], 200);
    }

    //update post
    public function update(Request $request, $id)
    {
        $post = Post::find($id);

        if(!$post)
        {
            return response([
                'message' => 'Post not found'
            ], 403);
        }
        
        if($post->user_id != auth()->user()->id)
        {
            return response([
                'message' => 'Permission denied'
            ], 403);
        }

        //validate fields
        $attrs = $request -> validate([
            'body' => 'required|string'
        ]);

        $post->update([
            'body' => $attrs['body']
        ]);

        //image

        //
        return response([
            'message' => 'Post updated',
            'post' => $post
        ], 200);
    }

    //delete post
    public function destroy($id)
    {
        $post = Post::find($id);

        if(!$post)
        {
            return response([
                'message' => 'Post not found'
            ], 403);
        }
        
        if($post->user_id != auth()->user()->id)
        {
            return response([
                'message' => 'Permission denied'
            ], 403);
        }

        $post->delete();
        
        return response([
            'message' => 'Post deleted',
        ], 200);
    }
}
