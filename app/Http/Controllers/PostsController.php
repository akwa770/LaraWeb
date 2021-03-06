<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return Post::latest()->paginate(5);

        // return ['message' => 'Posts page'];

        $posts = Post::latest()->paginate(5);

        $postsData = [
            'posts' => $posts,
            'posts_count' => Post::all()->count(),
            'aaa' => 'aaa'
        ];
        
        // return ['message' => 'getCountPosts'];
        return $postsData;
        // return $posts;

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
        $this->validate($request,
        [
            'title' => 'required|string|max:191',
            'body' => 'required|string|max:3000',
     
        ]);
        return Post::create([
            'title' => $request['title'],
            'body' => $request['body'],
            'photo' => $request['photo'],
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrfail($id);
        
        return  $post;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        $post = Post::findOrfail($id);
        $post->update($request->all());

        $this->validate($request,
        [
            'title' => 'required|string|max:191',
            'body' => 'required|string|max:3000',
     
        ]);

        return ['message' => 'Post Updated'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrfail($id);

        $post->delete();

        return ['message' => 'Post Deleted'];

    }
}
