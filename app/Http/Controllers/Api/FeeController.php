<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\Student;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    public function studentFees(Student $student)
    {
        return response()->json($student->fees()->latest()->get());
    }

    public function markPaid(Fee $fee)
    {
        $fee->update(['status' => 'paid', 'paid_at' => now()]);
        return response()->json($fee);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id' => 'required|exists:students,id',
            'session' => 'required',
            'amount' => 'required|numeric',
        ]);
        return response()->json(Fee::create($data), 201);
    }
}
