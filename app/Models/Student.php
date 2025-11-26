<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Student extends Model
{
    use HasApiTokens;

    protected $fillable = ['nis', 'name', 'password', 'class_id', 'email', 'phone', 'photo_embedding'];

    protected $hidden = ['password'];

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function classModel()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }
}
