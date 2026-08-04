<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    protected $fillable = ['course_id', 'day', 'start_time', 'end_time', 'venue'];
    public function course() { return $this->belongsTo(Course::class); }
}
