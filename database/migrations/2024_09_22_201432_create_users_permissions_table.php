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
        Schema::create('users_permissions', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('module_id');
            $table->unsignedBigInteger('options_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->bigInteger('status')->default(1);

            $table->primary('id');
            $table->index(['module_id', 'options_id', 'user_id']);
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_permissions');
    }
};
