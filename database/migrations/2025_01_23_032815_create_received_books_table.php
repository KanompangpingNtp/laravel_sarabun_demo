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
        Schema::create('received_books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')->constrained()->onDelete('cascade');
            $table->string('register_type')->nullable();
            $table->string('number_receive')->nullable();
            $table->string('book_number')->nullable();
            $table->string('book_year')->nullable();
            $table->string('book_receipt_number')->nullable();
            $table->enum('urgency_level', ['1', '2', '3'])->nullable();
            $table->date('received_date')->nullable();
            $table->date('date_receipt')->nullable();
            $table->date('registered_date')->nullable();
            $table->string('subject')->nullable();
            $table->string('to_person')->nullable();
            $table->string('reference')->nullable();
            $table->text('content')->nullable();
            $table->text('note')->nullable();
            $table->string('from_person')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('received_books');
    }
};
