<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('title');
            $table->unsignedTinyInteger('unit');
            $table->foreignId('department_id')->constrained();
            $table->foreignId('lecturer_id')->nullable()->constrained('lecturers');
            $table->enum('semester', ['first', 'second']);
            $table->unsignedTinyInteger('level')->default(100);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('courses'); }
};
