<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:post-list|post-create|post-edit|post-delete', ['only' => ['index','show']]);
        $this->middleware('permission:post-create', ['only' => ['create','store']]);
        $this->middleware('permission:post-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:post-delete', ['only' => ['destroy']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->paginate(5);
        return view('posts.index', compact('posts'))
            ->with('i'.(request()->input('page', 1) -1) *5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'desc' => 'required',
            'photo' => 'required',
            'file' => 'required|file',
        ]);

        $file = $request->file('file');
        $new_file = rand() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('file'), $new_file);
        $form_data = array(
            'name' => $request->name,
            'desc' => $request->desc,
            'photo' => $request->photo,
            'file' => $new_file,
        );
        return redirect()->route('post.index')
            ->with('success', "Post created");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $posts = Post::findOrFail($id);
        return view('post.show',compact('posts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $posts = Post::findOrFail($id);
        return view('post.edit',compact('posts'));
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
        $new_file = $request->hidden_file;
        $file = $request->file('file');
        if ($file != '') {
            $request->validate([
                'name' => 'required',
                'desc' => 'required',
                'photo' => 'required',
                'file' => 'required|file',
            ]);

            $new_file = rand() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('file'), $new_file);
        }
        else {
            $request->validate([
                'name' => 'required',
                'desc' => 'required',
                'photo' => 'required',
            ]);
        }
        $form_data = array(
            'name' => $request->name,
            'desc' => $request->desc,
            'photo' => $request->photo,
            'file' => $new_file,
        );
        Post::whereId($id)->update($form_data);
        return redirect()->route('post.index')
            ->with('success', "Post updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $posts = Post::findOrFail($id);
        $posts->delete();

        return redirect('post.index')->with('success', 'Post deleted');
    }
}
