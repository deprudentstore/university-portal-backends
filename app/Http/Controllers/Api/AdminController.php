<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Lecturer;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function stats()
    {
        return response()->json([
            'students' => Student::count(),
            'lecturers' => Lecturer::count(),
            'departments' => Department::count(),
            'courses' => \App\Models\Course::count(),
        ]);
    }

    public function departments() { return response()->json(Department::withCount('students')->get()); }

    public function storeDepartment(Request $request)
    {
        $data = $request->validate(['name' => 'required', 'code' => 'required|unique:departments,code', 'faculty' => 'required']);
        return response()->json(Department::create($data), 201);
    }

    public function students() { return response()->json(Student::with(['user', 'department'])->get()); }

    public function storeLecturer(Request $request)
    {
        $data = $request->validate([
            'name' => 'required', 'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8', 'staff_no' => 'required|unique:lecturers,staff_no',
            'department_id' => 'required|exists:departments,id',
        ]);
        $user = User::create(['name' => $data['name'], 'email' => $data['email'], 'password' => Hash::make($data['password']), 'role' => 'lecturer']);
        $lecturer = Lecturer::create(['user_id' => $user->id, 'staff_no' => $data['staff_no'], 'department_id' => $data['department_id']]);
        return response()->json($lecturer->load('user'), 201);
    }
}
