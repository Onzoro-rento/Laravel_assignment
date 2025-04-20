<?php

namespace Tests\Feature;

use App\Models\Posts;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_edit_delete_post()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $post = Posts::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseHas('posts', ['id' => $post->id]);

        $this->put(route('posts.update', $post), [
            'title' => '編集後',
            'body' => '編集済み本文',
        ]);

        $this->assertDatabaseHas('posts', ['title' => '編集後']);

        $this->delete(route('posts.destroy', $post));
        $this->assertSoftDeleted($post);
    }

    public function test_non_owner_cannot_edit_or_delete()
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();

        $post = Posts::factory()->create(['user_id' => $owner->id]);
        $this->actingAs($other);

        $this->put(route('posts.update', $post), [
            'title' => '不正編集',
            'body' => '不正本文',
        ])->assertForbidden();

        $this->delete(route('posts.destroy', $post))->assertForbidden();
    }
}
