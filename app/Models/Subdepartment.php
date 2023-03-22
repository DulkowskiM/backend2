<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subdepartment extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'id_department'];
    protected $primaryKey =  'id';
    public function department()
    {
        return $this->belongsTo(Department::class, 'id_department');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'id_subdepartment');
    }
}
