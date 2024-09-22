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
        Schema::create('module_options', function (Blueprint $table) {
            $table->bigIncrements('id');  // Equivalent to BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->unsignedBigInteger('module_id');  // Equivalent to BIGINT UNSIGNED NOT NULL
            $table->string('name', 255);  // Equivalent to VARCHAR(255) NOT NULL
            $table->string('machine_name', 255)->unique();  // Equivalent to VARCHAR(255) NOT NULL UNIQUE
            $table->timestamps();
            $table->unsignedBigInteger('status')->default(1);  // Equivalent to BIGINT NOT NULL DEFAULT 1

            // Indexes
            $table->index('module_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('module_options');
    }
};
