<?php

use App\Enums\AcademicYear;
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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('academic_year', [
                AcademicYear::FirstYear->value,
                AcademicYear::SecondYear->value,
                AcademicYear::ThirdYear->value,
                AcademicYear::FourthYear->value,
                AcademicYear::FifthYear->value
            ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};