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
        Schema::create('document_pdfs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('received_book_id')->constrained('received_books')->onDelete('cascade');
            $table->string('pdf_files');
            $table->string('pdf_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_pdfs');
    }
};
