<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_update_info()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->patch('/profile', [
            'name' => '新しい名前',
            'email' => 'new@example.com',
        ]);

        $this->assertDatabaseHas('users', ['name' => '新しい名前']);
    }

    public function test_user_posts_hidden_after_withdrawal()
    {
        $user = User::factory()->create();
        $post = \App\Models\Posts::factory()->create(['user_id' => $user->id]);

        $user->delete();

        $visiblePosts = \App\Models\Posts::whereHas('user', function ($q) {
            $q->whereNull('deleted_at');
        })->get();

        $this->assertFalse($visiblePosts->contains($post));
    }
}
