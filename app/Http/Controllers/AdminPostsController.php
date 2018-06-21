<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Photo;
use App\Category;
use App\Http\Requests;
use App\Http\Requests\PostsCreateRequest;
use App\Http\Requests\PostsEditRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminPostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::paginate(2);
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::lists('name', 'id')->all();
        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostsCreateRequest $request)
    {        
        $user = Auth::user();
        $input = $request->all();
        if ($file = $request->file('photo_id')) {
            $name = time() . $file->getClientOriginalName();
            $file->move('images', $name);
            $photo = Photo::create(['path'=>$name]);
            $input['photo_id'] = $photo->id;
        }
        // Can use this method tho
        // $input['user_id'] = $user->id;        
        $post = $user->posts()->create($input);
        Session::flash('post_created', 'The post '.$post->title.' has been created!');
        return redirect('admin/posts');
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::lists('name', 'id')->all();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostsEditRequest $request, $id)
    {
        if (trim($request->photo_id) !='') {
            $input = $request->all();
            if ($file = $request->file('photo_id')) {
                $name = time() . $file->getClientOriginalName();
                $file->move('images', $name);
                $photo = Photo::create(['path'=>$name]);
                $input['photo_id'] = $photo->id;
            }
        } else {
            $input = $request->except('photo_id');
        }
        $post = Post::findOrFail($id);
        $post->update($input);
        Session::flash('post_edited', 'The post '.$post->title.' has been updated!');
        return redirect('admin/posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if($post->photo_id != 0 || $post->photo_id != '') {
            unlink(public_path() . $post->photo->path);
        }
        $post->delete();
        Session::flash('post_deleted', 'The post has been deleted!');
        return redirect('admin/posts');
    }

    public function post($id) {
        $post = Post::findOrFail($id);
        $comments = $post->comments()->whereIsActive(1)->get();
        return view('post', compact('post', 'comments'));
    }
}
