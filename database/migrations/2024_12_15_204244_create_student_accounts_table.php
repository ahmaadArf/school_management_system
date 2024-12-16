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
        Schema::create('student_accounts', function (Blueprint $table) {
            // $table->id();
            // $table->date('date');
            // $table->foreignId('Grade_id')->nullable()->constrained('grades')->onDelete('cascade');
            // $table->foreignId('Classroom_id')->nullable()->constrained('classrooms')->onDelete('cascade');
            // $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            // $table->decimal('Debit',8,2)->nullable();
            // $table->decimal('credit',8,2)->nullable();
            // $table->string('description')->nullable();
            // $table->timestamps();

            // $table->id();
            // $table->date('date');
            // $table->string('type');
            // $table->foreignId('fee_invoice_id')->constrained('fee_invoices')->onDelete('cascade');
            // $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            // $table->decimal('Debit',8,2)->nullable();
            // $table->decimal('credit',8,2)->nullable();
            // $table->string('description')->nullable();
            // $table->timestamps();

            $table->id();
            $table->date('date');
            $table->string('type');
            $table->foreignId('fee_invoice_id')->nullable()->constrained('fee_invoices')->onDelete('cascade');
            $table->foreignId('receipt_id')->nullable()->constrained('receipt_students')->onDelete('cascade');
            $table->foreignId('processing_id')->nullable()->constrained('processing_fees')->onDelete('cascade');
            $table->foreignId('payment_id')->nullable()->constrained('payment_students')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->decimal('Debit',8,2)->nullable();
            $table->decimal('credit',8,2)->nullable();
            $table->string('description')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_accounts');
    }
};
