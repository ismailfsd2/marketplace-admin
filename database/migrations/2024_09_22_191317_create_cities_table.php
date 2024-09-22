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
        Schema::create('cities', function (Blueprint $table) {
            $table->bigIncrements('id');  // Equivalent to BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->string('name', 255);  // Equivalent to VARCHAR(255) NOT NULL
            $table->unsignedBigInteger('state_id');  // Equivalent to BIGINT UNSIGNED NOT NULL
            $table->string('state_code', 255);  // Equivalent to VARCHAR(255) NOT NULL
            $table->unsignedBigInteger('country_id');  // Equivalent to BIGINT UNSIGNED NOT NULL
            $table->char('country_code', 2);  // Equivalent to CHAR(2) NOT NULL
            $table->decimal('latitude', 10, 8);  // Equivalent to DECIMAL(10,8) NOT NULL
            $table->decimal('longitude', 11, 8);  // Equivalent to DECIMAL(11,8) NOT NULL
            $table->unsignedBigInteger('created_by');  // Equivalent to BIGINT UNSIGNED NOT NULL
            $table->timestamps();
            $table->unsignedBigInteger('status')->default(1);  // Equivalent to BIGINT DEFAULT 1
            // Indexes
            $table->index('country_id');
            $table->index('state_id');
            $table->index('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
