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
        Schema::create('users_activities', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('module_id');
            $table->unsignedBigInteger('module_option_id');
            $table->text('action_detail');
            $table->timestamps();

            $table->primary('id');
            $table->index(['user_id', 'module_id', 'module_option_id']);
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_activities');
    }
};
