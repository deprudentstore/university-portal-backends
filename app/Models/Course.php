<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['code', 'title', 'unit', 'department_id', 'lecturer_id', 'semester', 'level'];
    public function department() { return $this->belongsTo(Department::class); }
    public function lecturer() { return $this->belongsTo(Lecturer::class); }
    public function enrollments() { return $this->hasMany(Enrollment::class); }
    public function timetables() { return $this->hasMany(Timetable::class); }
}
