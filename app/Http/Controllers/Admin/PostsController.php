<?php

namespace Koolbeans\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Koolbeans\Http\Controllers\Controller;
use Koolbeans\Http\Requests;
use Koolbeans\Post;

class PostsController extends Controller
{

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->get();

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $post = new Post;

        return view('admin.posts.create', compact('post'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $post          = new Post;
        $post->title   = $request->input('title');
        $post->content = $request->input('content');

        $post->save();

        return redirect(route('admin.post.index'))->with('messages', ['success' => 'Post created!']);
    }

    /**
     * @param string $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $post = Post::find($id);

        return view('admin.posts.edit', compact('post'));
    }

    /**
     * @param string                   $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, Request $request)
    {
        $post          = Post::find($id);
        $post->title   = $request->input('title');
        $post->content = $request->input('content');

        $post->save();

        return redirect(route('admin.post.index'))->with('messages', ['success' => 'Post updated!']);
    }

}