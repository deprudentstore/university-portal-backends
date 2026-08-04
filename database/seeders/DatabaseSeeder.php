<?php
namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $dept = Department::create(['name' => 'Computer Science', 'code' => 'CSC', 'faculty' => 'Science']);
        Department::create(['name' => 'Physiotherapy', 'code' => 'PHT', 'faculty' => 'Health Sciences']);

        User::create([
            'name' => 'Portal Admin',
            'email' => 'admin@university.edu',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);
    }
}
