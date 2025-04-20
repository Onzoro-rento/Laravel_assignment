<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Posts;
use Illuminate\Database\Eloquent\SoftDeletes;

class Replies extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'title',
        'body',
        'post_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function post()
    {
        return $this->belongsTo(Posts::class, 'post_id', 'id');
    }
    
    
}
