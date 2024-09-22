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
        Schema::create('countries', function (Blueprint $table) {
            $table->bigIncrements('id');  // Equivalent to BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->string('name', 100);  // Equivalent to VARCHAR(100) NOT NULL
            $table->char('iso3', 3)->nullable();  // Equivalent to CHAR(3) DEFAULT NULL
            $table->char('numeric_code', 3)->nullable();  // Equivalent to CHAR(3) DEFAULT NULL
            $table->char('iso2', 2)->nullable();  // Equivalent to CHAR(2) DEFAULT NULL
            $table->string('phonecode', 255)->nullable();  // Equivalent to VARCHAR(255) DEFAULT NULL
            $table->string('capital', 255)->nullable();  // Equivalent to VARCHAR(255) DEFAULT NULL
            $table->string('currency', 255)->nullable();  // Equivalent to VARCHAR(255) DEFAULT NULL
            $table->string('currency_name', 255)->nullable();  // Equivalent to VARCHAR(255) DEFAULT NULL
            $table->string('currency_symbol', 255)->nullable();  // Equivalent to VARCHAR(255) DEFAULT NULL
            $table->string('tld', 255)->nullable();  // Equivalent to VARCHAR(255) DEFAULT NULL
            $table->string('native', 255)->nullable();  // Equivalent to VARCHAR(255) DEFAULT NULL
            $table->string('region', 255)->nullable();  // Equivalent to VARCHAR(255) DEFAULT NULL
            $table->unsignedBigInteger('region_id')->nullable();  // Equivalent to BIGINT UNSIGNED DEFAULT NULL
            $table->string('subregion', 255)->nullable();  // Equivalent to VARCHAR(255) DEFAULT NULL
            $table->unsignedBigInteger('subregion_id')->nullable();  // Equivalent to BIGINT UNSIGNED DEFAULT NULL
            $table->string('nationality', 255)->nullable();  // Equivalent to VARCHAR(255) DEFAULT NULL
            $table->text('timezones')->nullable();  // Equivalent to TEXT DEFAULT NULL
            $table->text('translations')->nullable();  // Equivalent to TEXT DEFAULT NULL
            $table->decimal('latitude', 10, 8)->nullable();  // Equivalent to DECIMAL(10,8) DEFAULT NULL
            $table->decimal('longitude', 11, 8)->nullable();  // Equivalent to DECIMAL(11,8) DEFAULT NULL
            $table->unsignedBigInteger('created_by');  // Equivalent to BIGINT UNSIGNED NOT NULL
            $table->timestamps();
            $table->unsignedBigInteger('status')->default(1);  // Equivalent to BIGINT DEFAULT 1

            // Indexes
            $table->index('region_id');
            $table->index('subregion_id');
            $table->index('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
