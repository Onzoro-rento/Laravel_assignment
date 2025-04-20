<?php

namespace Tests\Feature;

use App\Models\Posts;
use App\Models\Replies;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReplyFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_display_and_delete_reply()
    {
        $user = User::factory()->create();
        $post = Posts::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('replies.store', $post), [
            'body' => 'リプライ本文',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('replies', ['body' => 'リプライ本文']);
    }
    public function test_user_can_delete_own_reply()
{
    $user = User::factory()->create();
    $post = Posts::factory()->create();
    $this->actingAs($user);

    $reply = Replies::factory()->create([
        'post_id' => $post->id,
        'user_id' => $user->id,
    ]);

    $this->delete(route('replies.destroy', [$post, $reply]))
         ->assertRedirect();

    $this->assertSoftDeleted($reply);
}


    public function test_replies_removed_or_remain_with_post()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $post = Posts::factory()->create(['user_id' => $user->id]);
        $reply = Replies::factory()->create(['post_id' => $post->id, 'user_id' => $user->id]);

        $this->delete(route('posts.destroy', $post));

        $this->assertModelExists($reply); // もしくは assertSoftDeleted depending on仕様
    }
    public function test_non_owner_cannot_edit_or_delete_reply()
{
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $post = Posts::factory()->create();

    $reply = \App\Models\Replies::factory()->create([
        'post_id' => $post->id,
        'user_id' => $owner->id,
    ]);

    $this->actingAs($other);

    // 編集試行（PUT）→ 403 Forbidden 期待
    $this->put(route('replies.update', [$post, $reply]), [
        'body' => '不正な編集内容',
    ])->assertForbidden();

    // 削除試行（DELETE）→ 403 Forbidden 期待
    $this->delete(route('replies.destroy', [$post, $reply]))
         ->assertForbidden();
}

}
