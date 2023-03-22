<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    protected $primaryKey = 'id';
    public function department()
    {
        return $this->belongsTo(Subdepartment::class, 'id_subdepartment');
    }
}
