<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Posts;
use App\Models\Replies;
use App\Policies\PostsPolicy;
use App\Policies\RepliesPolicy; 

class AuthServiceProvider extends ServiceProvider
{
    /**
     * モデルとポリシーのマッピング
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Posts::class => PostsPolicy::class,
        Replies::class => RepliesPolicy::class,
    ];

    /**
     * ポリシーを登録
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
