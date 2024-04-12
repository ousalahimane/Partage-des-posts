<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreRequest;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{

    public function __construct(){
        $this->middleware('auth')->except(['index', 'show', 'all', 'archive']);
    }

    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        return view('posts.index', [
            'posts' =>Post::postWithUserCommentsTags()->get(),
            'tab' => 'list' 
        ]);
    }

    public function archive()
    {
        $posts = Post::onlyTrashed()->withCount('comments')->get();
        return view('posts.index', [
            'posts' => $posts,
            'mostCommented' => Post::mostCommented()->take(5)->get(),
            'manyPosts' => User::manyPosts()->take(5)->get(),
            'activeInLastMonth' => User::UserActiveInLastMonth()->take(5)->get(),
            'tab' => 'archive'
        ]);
    }

    public function all()
    {
        return view('posts.index', [
            'posts' => Post::withTrashed()->withCount('comments')->get(),
            'mostCommented' => Post::mostCommented()->take(5)->get(),
            'manyPosts' => User::manyPosts()->take(5)->get(),
            'activeInLastMonth' => User::UserActiveInLastMonth()->take(5)->get(),
            'tab' => 'all'
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $this->authorize('create');
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
            $data = $request->only(['title', 'content']);
            $data['slug'] = Str::slug($data['title'],'-');
            $data['active'] = false;
            $data['user_id'] = $request->user()->id;
            $post = Post::create($data);
         
          if($request->hasFile('picture')){

            $path = $request->file('picture')->store('posts');
             
            $image = new Image(['path' => $path]);

            $post->image()->save($image);

          }

       $request->session()->flash('status', 'post was created !!');
    //    return redirect()->route('posts.index');
       return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Cache::remember("post-show-{$id}", 60, function() use($id){
            return Post::with(['comments', 'tags'])->findOrFail($id); //eager
        });

        return view('posts.show', [
            'post' => $post
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::findOrFail($id);
        $this->authorize('update', $post);

        return view('posts.edit', [
            'post' => $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRequest $request, string $id)
    {
        $post = Post::findOrFail($id);
        $this->authorize('update', $post);

        //   Upload picture from current post
            if($request->hasFile('picture')){

                $path = $request->file('picture')->store('posts');
                
                if($post->image){
                    Storage::delete($post->image->path);
                    $post->image->path = $path;
                    $post->image->save();

                }else{
                    // $post->image->save(Image::create(['path' => $path]));
                    $post->image()->create(['path' => $path]);
                }
                
                $image = new Image(['path' => $path]);

                $post->image()->save($image);

            }

        $post->title = $request->input('title');
        $post->content =  $request->input('content');
        $post->slug = Str::slug('$post->title', '-');
        $post->active = false;

        $post->save();
        $request->session()->flash('status', 'post was updated !!');
        return redirect()->route('posts.index');

        

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request ,string $id)
    {
        $post = Post::find($id);
        $this->authorize('delete', $post);
        $post->delete();
        // Post::destroy($id);
        // $request->session()->flash('status', 'post was deleted !!');
        return redirect()->route('posts.index');

    }

    public function restore($id){
        $post = Post::onlyTrashed()->whereId($id)->first();
        $this->authorize('restore', $post);
        $post->restore();
        return redirect()->back();
        }

    public function forceDelete($id){
       $post = Post::onlyTrashed()->whereId($id)->first();
       $this->authorize('forceDelete', $post);
       $post->forceDelete();
       return redirect()->back();
       }
}
