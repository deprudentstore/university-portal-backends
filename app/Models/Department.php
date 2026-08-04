<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['name', 'code', 'faculty'];
    public function students() { return $this->hasMany(Student::class); }
    public function courses() { return $this->hasMany(Course::class); }
}
