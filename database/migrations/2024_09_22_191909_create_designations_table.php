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
        Schema::create('designations', function (Blueprint $table) {
            $table->bigIncrements('id');  // Equivalent to BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->string('name', 255);  // Equivalent to VARCHAR(255) NOT NULL
            $table->text('details');  // Equivalent to TEXT NOT NULL
            $table->unsignedBigInteger('created_by');  // Equivalent to BIGINT UNSIGNED NOT NULL
            $table->timestamps();
            $table->unsignedBigInteger('status')->default(1);  // Equivalent to BIGINT NOT NULL DEFAULT 1

            // Indexes
            $table->index('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('designations');
    }
};
