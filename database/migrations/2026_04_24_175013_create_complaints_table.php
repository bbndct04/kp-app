<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('reference_number')->unique();
            $table->string('category');
            $table->text('description');
            $table->date('incident_date');
            $table->time('incident_time')->nullable();
            $table->string('location');
            $table->string('persons_involved')->nullable();
            $table->string('attachment')->nullable();
            $table->enum('status', ['pending','under_review','resolved','rejected'])->default('pending');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};