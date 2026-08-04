<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['user_id', 'matric_no', 'department_id', 'level', 'cgpa'];
    public function user() { return $this->belongsTo(User::class); }
    public function department() { return $this->belongsTo(Department::class); }
    public function enrollments() { return $this->hasMany(Enrollment::class); }
    public function fees() { return $this->hasMany(Fee::class); }
}
