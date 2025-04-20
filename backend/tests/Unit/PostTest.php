<?php

namespace Tests\Unit;

use App\Models\Posts;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_post_crud_operations()
    {
        $user = User::factory()->create();
        $post = Posts::create([
            'user_id' => $user->id,
            'title' => 'タイトル',
            'body' => '本文'
        ]);

        $this->assertDatabaseHas('posts', ['title' => 'タイトル']);

        $post->update(['title' => '更新タイトル']);
        $this->assertDatabaseHas('posts', ['title' => '更新タイトル']);

        $post->delete();
        $this->assertSoftDeleted($post);
    }

    public function test_hidden_posts_of_deleted_users()
    {
        $user = User::factory()->create();
        $post = Posts::factory()->create([
            'user_id' => $user->id,
            'title' => 'テストタイトル',
            'body' => 'テスト本文',
        ]);
    
        $user->delete();
    
        $visiblePosts = Posts::whereHas('user', function ($query) {
            $query->whereNull('deleted_at');
        })->get();
    
        $this->assertFalse($visiblePosts->contains($post));
    }
    
}
