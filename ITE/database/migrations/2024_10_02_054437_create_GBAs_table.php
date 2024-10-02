<?php

use App\Enums\AcademicYear;
use App\Models\User;
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
        Schema::create('GBAs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'student_id')->constrained('users')->cascadeOnDelete();
            $table->enum('academic_year', [
                AcademicYear::FirstYear->value,
                AcademicYear::SecondYear->value,
                AcademicYear::ThirdYear->value,
                AcademicYear::FourthYear->value,
                AcademicYear::FifthYear->value
            ]);
            $table->date('year');
            $table->integer('average');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('GBAs');
    }
};
