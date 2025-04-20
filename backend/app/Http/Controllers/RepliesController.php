<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRepliesRequest;
use App\Http\Requests\UpdateRepliesRequest;
use App\Models\Replies;
use App\Models\Posts;
use Inertia\Inertia;

class RepliesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   $replies= Replies::select('user_id', 'id', 'body','created_at')
        ->with(['user' => function ($query) {
            $query->whereNull('deleted_at'); // ← 論理削除されたユーザーを除外
        }])
        ->orderBy('created_at', 'desc')
        ->get();
        return Inertia::render('Posts/Index', [
            'replies' => Replies::with(['user:id,name'])->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Posts $post)
    {   
        return Inertia::render('Replies/Create',
        ['post' => $post->load('user:id,name'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRepliesRequest $request, Posts $post)
    {   

        Replies::create([
            'user_id' => $request->user()->id,
            'post_id' => $post->id,
            'body' => $request->body,
        ]);
        return to_route('posts.index')
        ->with([
            'message' => '返信しました',
            'status' => 'success',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Replies $replies)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Posts $post,Replies $reply)
    {
        return Inertia::render('Replies/Edit', [
            'replies' => $reply

        ]);    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRepliesRequest $request, Posts $post, Replies $reply)
{
    $reply->body = $request->body;
    $reply->user_id = $request->user()->id;
    $reply->post_id = $post->id;
    $reply->save();

    return to_route('posts.index')->with([
        'message' => '更新しました',
        'status' => 'success',
    ]);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Posts $post,Replies $reply)
    {
        $reply->delete();
        return to_route('posts.index')
        ->with([
            'message' => '削除しました',
            'status' => 'success',
        ]);

    }
    public function __construct()
{
    $this->middleware('auth');
    $this->authorizeResource(\App\Models\Replies::class, 'reply');
}
    
}
