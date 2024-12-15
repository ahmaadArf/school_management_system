<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->foreignId('gender_id')->constrained('genders')->onDelete('cascade');
            $table->foreignId('nationalitie_id')->constrained('nationalities')->onDelete('cascade');
            $table->foreignId('blood_id')->constrained('type_bloods')->onDelete('cascade');
            $table->date('Date_Birth');
            $table->foreignId('Grade_id')->constrained('Grades')->onDelete('cascade');
            $table->foreignId('Classroom_id')->constrained('Classrooms')->onDelete('cascade');
            $table->foreignId('section_id')->constrained('sections')->onDelete('cascade');
            $table->foreignId('parent_id')->constrained('my_parents')->onDelete('cascade');
            $table->string('academic_year');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
