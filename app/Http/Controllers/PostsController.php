<?php

namespace Koolbeans\Http\Controllers;

use Koolbeans\Post;

class PostsController extends Controller
{
    /**
     * @return mixed
     */
    public function index()
    {
        $posts = Post::paginate(10);

        return view('posts.index', compact('posts'));
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function show($id)
    {
        return view('posts.show', ['post' => Post::find($id)]);
    }
}
