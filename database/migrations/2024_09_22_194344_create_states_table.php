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
        Schema::create('states', function (Blueprint $table) {
            $table->bigIncrements('id');  // Equivalent to BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->string('name', 255);  // Equivalent to VARCHAR(255) NOT NULL
            $table->unsignedBigInteger('country_id');  // Equivalent to BIGINT UNSIGNED NOT NULL
            $table->char('country_code', 2);  // Equivalent to CHAR(2) NOT NULL
            $table->string('fips_code')->nullable();  // Equivalent to VARCHAR(255) DEFAULT NULL
            $table->string('iso2')->nullable();  // Equivalent to VARCHAR(255) DEFAULT NULL
            $table->string('type')->nullable();  // Equivalent to VARCHAR(191) DEFAULT NULL
            $table->decimal('latitude', 10, 8)->nullable();  // Equivalent to DECIMAL(10,8) DEFAULT NULL
            $table->decimal('longitude', 11, 8)->nullable();  // Equivalent to DECIMAL(11,8) DEFAULT NULL
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
        Schema::dropIfExists('states');
    }
};
