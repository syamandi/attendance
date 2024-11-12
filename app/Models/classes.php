<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class classes extends Model
{
    use HasFactory;
    protected $table = "classes";
    
    public $timestamps = false;


public function students()
{
    return $this->hasMany(students::class, 'class_id');
}


}
