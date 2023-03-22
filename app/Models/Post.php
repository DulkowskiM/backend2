<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'content', 'id_topic', 'id_user',
    ];
    protected $primaryKey = 'id_post';
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
