<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Inertia\Inertia;

class BlogController extends Controller
{
    public function index()
    {
        return Inertia::render('Blog/Index', [
            'posts' => Post::all()
        ]);
    }

    public function create()
    {
        return Inertia::render('Blog/Create');
    }

    public function edit($id)
    {
        $post = Post::find($id);
        return Inertia::render('Blog/Edit', [
            'post' => $post
        ]);
    }

    public function update($id)
    {
        $post = Post::find($id);
        $slug = Str::slug(request()->get('name'));
        $data = array_merge(request()->all(), ['slug' => $slug]);

        $validator = Validator::make($data, [
            'name'      => 'required',
            'slug'      => 'required|unique:posts,slug,' . $post->id,
            'content'   => 'required',
            'published' => 'required',
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $post->name = request()->get('name');
        $post->slug = $slug;
        $post->content = request()->get('content');
        $post->published = request()->get('published');
        $post->save();

        return redirect()->route('blog.index');
    }

    public function store()
    {
        $slug = Str::slug(request()->get('name'));
        $data = array_merge(request()->all(), ['slug' => $slug]);

        $validator = Validator::make($data, [
            'name'      => 'required',
            'slug'      => 'required|unique:posts',
            'content'   => 'required',
            'published' => 'required',
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $post = new Post();
        $post->name = request()->get('name');
        $post->slug = $slug;
        $post->content = request()->get('content');
        $post->published = request()->get('published');
        $post->save();

        return redirect()->route('blog.index');
    }


    public function toggle($id)
    {
        $post = Post::find($id);
        $post->published = !$post->published;
        $post->save();

        return redirect()->back();
    }
}
