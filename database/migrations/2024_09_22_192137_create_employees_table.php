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
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');  // Equivalent to BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->string('first_name', 255);  // Equivalent to VARCHAR(255) NOT NULL
            $table->string('last_name', 255);  // Equivalent to VARCHAR(255) NOT NULL
            $table->unsignedBigInteger('designation_id');  // Equivalent to BIGINT UNSIGNED NOT NULL
            $table->unsignedBigInteger('department_id');  // Equivalent to BIGINT UNSIGNED NOT NULL
            $table->string('phone_number', 255);  // Equivalent to VARCHAR(255) NOT NULL
            $table->string('email', 255)->unique();  // Equivalent to VARCHAR(255) NOT NULL UNIQUE
            $table->string('picture', 255);  // Equivalent to VARCHAR(255) NOT NULL
            $table->unsignedBigInteger('country_id');  // Equivalent to BIGINT UNSIGNED NOT NULL
            $table->unsignedBigInteger('state_id');  // Equivalent to BIGINT UNSIGNED NOT NULL
            $table->unsignedBigInteger('city_id');  // Equivalent to BIGINT UNSIGNED NOT NULL
            $table->string('postal_code', 255);  // Equivalent to VARCHAR(255) NOT NULL
            $table->string('address', 255);  // Equivalent to VARCHAR(255) NOT NULL
            $table->unsignedBigInteger('created_by');  // Equivalent to BIGINT UNSIGNED NOT NULL
            $table->timestamps();
            $table->unsignedBigInteger('status')->default(1);  // Equivalent to BIGINT NOT NULL DEFAULT 1

            // Indexes
            $table->index('city_id');
            $table->index('country_id');
            $table->index('created_by');
            $table->index('department_id');
            $table->index('designation_id');
            $table->index('state_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
