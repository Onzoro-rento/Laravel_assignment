<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Posts;

class PostsPolicy
{
    public function viewAny(\App\Models\User $user): bool
{
    return true; // 認証済みユーザーなら誰でも一覧を見れる
}

    
public function create(User $user): bool
{
    return true; // 全員作成OK
}

public function update(User $user, Posts $post): bool
{
    return $user->id === $post->user_id; // 投稿者のみ編集OK
}

public function delete(User $user, Posts $post): bool
{
    return $user->id === $post->user_id; // 投稿者のみ削除OK
}
}
