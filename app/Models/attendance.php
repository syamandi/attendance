<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class attendance extends Model
{
    use HasFactory;
    protected $table = "attendance";
    protected $casts = [
        'date' => 'datetime',
    ];
    protected $fillable = [
        'student_id', 
        'class_id',
        'date',
        'status',
    ];
    public $timestamps = false;
    public function student()
{
    return $this->belongsTo(students::class, 'student_id');
}

}
