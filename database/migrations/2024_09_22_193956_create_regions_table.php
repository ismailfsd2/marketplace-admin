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
        Schema::create('regions', function (Blueprint $table) {
            $table->bigIncrements('id');  // Equivalent to BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->string('name', 100);  // Equivalent to VARCHAR(100) NOT NULL
            $table->text('translations')->nullable();  // Equivalent to TEXT DEFAULT NULL
            $table->unsignedBigInteger('created_by');  // Equivalent to BIGINT UNSIGNED NOT NULL
            $table->timestamps();
            $table->unsignedBigInteger('status')->default(1);  // Equivalent to BIGINT DEFAULT 1
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regions');
    }
};
