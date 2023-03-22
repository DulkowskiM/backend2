<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    protected $primaryKey = 'id';
    public function subdepartment()
    {
        return $this->hasMany(Subdepartment::class, 'id');
    }
}
