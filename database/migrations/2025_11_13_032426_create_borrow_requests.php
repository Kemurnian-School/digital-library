<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('borrow_requests', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('student_id')->constrained('students');
            $table->foreignId('classroom_id')->nullable()->constrained('classroom');
            $table->foreignId('book_id')->constrained('books');
            $table->enum('status', ['pending', 'borrowed', 'rejected', 'finished'])->default('pending');
            $table->date('date_borrowed')->nullable();
            $table->date('date_returned')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrow_requests');
    }
};
