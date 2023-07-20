<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class employee extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'name',
        'mobile',
        'image',
        'department_id'
    ];
    function getDepartment()
    {
        return $this->hasOne(department::class, 'id', 'department_id');
    }
}
