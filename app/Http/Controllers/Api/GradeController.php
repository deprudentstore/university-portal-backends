<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Student;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function studentGrades(Student $student)
    {
        $grades = Grade::whereHas('enrollment', fn ($q) => $q->where('student_id', $student->id))
            ->with('enrollment.course')
            ->get();
        return response()->json($grades);
    }

    public function upsert(Request $request)
    {
        $data = $request->validate([
            'enrollment_id' => 'required|exists:enrollments,id',
            'score' => 'required|numeric|min:0|max:100',
        ]);

        [$letter, $point] = $this->gradeFromScore($data['score']);

        $grade = Grade::updateOrCreate(
            ['enrollment_id' => $data['enrollment_id']],
            ['score' => $data['score'], 'grade_letter' => $letter, 'grade_point' => $point]
        );

        return response()->json($grade);
    }

    private function gradeFromScore(float $score): array
    {
        return match (true) {
            $score >= 70 => ['A', 5.0],
            $score >= 60 => ['B', 4.0],
            $score >= 50 => ['C', 3.0],
            $score >= 45 => ['D', 2.0],
            $score >= 40 => ['E', 1.0],
            default => ['F', 0.0],
        };
    }
}
