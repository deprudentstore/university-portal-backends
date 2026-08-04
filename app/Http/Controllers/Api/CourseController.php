<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::with(['department', 'lecturer.user']);
        if ($request->has('level')) $query->where('level', $request->level);
        if ($request->has('semester')) $query->where('semester', $request->semester);
        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|unique:courses,code',
            'title' => 'required',
            'unit' => 'required|integer',
            'department_id' => 'required|exists:departments,id',
            'lecturer_id' => 'nullable|exists:lecturers,id',
            'semester' => 'required|in:first,second',
            'level' => 'required|integer',
        ]);
        return response()->json(Course::create($data), 201);
    }

    public function update(Request $request, Course $course)
    {
        $course->update($request->all());
        return response()->json($course);
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return response()->json(['message' => 'Deleted']);
    }

    public function enroll(Request $request)
    {
        $data = $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'session' => 'required|string',
        ]);
        $enrollment = Enrollment::create($data);
        return response()->json($enrollment, 201);
    }
}
