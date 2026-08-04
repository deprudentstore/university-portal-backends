<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = ['enrollment_id', 'score', 'grade_letter', 'grade_point'];
    public function enrollment() { return $this->belongsTo(Enrollment::class); }
}
