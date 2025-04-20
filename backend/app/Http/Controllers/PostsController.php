<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostsRequest;
use App\Http\Requests\UpdatePostsRequest;
use App\Models\Posts;
use App\Models\Replies;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Posts::select('user_id', 'id', 'body', 'title', 'created_at')
            ->with([
                'user:id,name', // ← 論理削除チェックは Eager Load 時ではなく whereHas で行う
                'replies' => function ($query) {
                    $query->with(['user:id,name'])
                          ->whereHas('user', function ($q) {
                              $q->whereNull('deleted_at');
                          });
                }
            ])
            ->whereHas('user', function ($query) {
                $query->whereNull('deleted_at'); // 投稿のユーザーが削除されていないことを条件に
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    
        return Inertia::render('Posts/Index', [
            'posts' => $posts,
            'auth' => [
                'user' => Auth::user(), 
            ],
        ]);
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Posts/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostsRequest $request)
    {
        Posts::create([
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'body' => $request->body,
        ]);
        return to_route('posts.index')
        ->with([
            'message' => '投稿しました',
            'status' => 'success',
        ]);
            
    }

    /**
     * Display the specified resource.
     */
    public function show(Posts $posts)
    {
        // return Inertia::render('Posts/Show', [
        //     'posts' => $posts,
        // ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Posts $post)
    {   
        
        // dd($post);
        return Inertia::render('Posts/Edit', [
            'posts' => $post,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostsRequest $request, Posts $post)
    {
        $post->title = $request->title;
        $post->body = $request->body;
        $post->user_id = $request->user()->id;
        $post->save();

        return to_route('posts.index')
        ->with([
            'message' => '更新しました',
            'status' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Posts $post)
    {
        $post->delete();
        return to_route('posts.index')
        ->with([
            'message' => '削除しました',
            'status' => 'success',
        ]);
    }
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(\App\Models\Posts::class, 'post');
    }
    }
