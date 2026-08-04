<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Timetable;
use Illuminate\Http\Request;

class TimetableController extends Controller
{
    public function index(Request $request)
    {
        $query = Timetable::with('course');
        if ($request->has('level')) {
            $query->whereHas('course', fn ($q) => $q->where('level', $request->level));
        }
        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'day' => 'required|in:Mon,Tue,Wed,Thu,Fri',
            'start_time' => 'required',
            'end_time' => 'required',
            'venue' => 'required',
        ]);
        return response()->json(Timetable::create($data), 201);
    }
}
