<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_topic';
    protected $fillable = ['content', 'id_category', 'name', 'id_user', 'is_open'];
    public function posts()
    {
        return $this->hasMany(Post::class, 'id_topic', 'id_topic');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
