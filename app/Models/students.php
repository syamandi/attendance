<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class students extends Model
{
    use HasFactory;
    protected $table = "students";
    public $timestamps = false;

    public function class()
    {
        return $this->belongsTo(classes::class, 'class_id');
    }

    public function attendances()
{
    return $this->hasMany(Attendance::class, 'student_id');
}
}
