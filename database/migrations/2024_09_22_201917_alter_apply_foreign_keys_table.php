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
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('employee_id')->references('id')->on('employees');
        });
        Schema::table('cities', function (Blueprint $table) {
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('countries', function (Blueprint $table) {
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('set null');
            $table->foreign('subregion_id')->references('id')->on('subregions')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('departments', function (Blueprint $table) {
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('designations', function (Blueprint $table) {
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('employees', function (Blueprint $table) {
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('designation_id')->references('id')->on('designations')->onDelete('cascade');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
        });
        Schema::table('modules', function (Blueprint $table) {
            $table->foreign('module_group_id')->references('id')->on('module_groups')->onDelete('cascade');
        });
        Schema::table('module_options', function (Blueprint $table) {
            $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');
        });
        Schema::table('regions', function (Blueprint $table) {
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('states', function (Blueprint $table) {
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('subregions', function (Blueprint $table) {
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('region_id')->references('id')->on('regions');
        });
        Schema::table('users_activities', function (Blueprint $table) {
            $table->foreign('module_id')->references('id')->on('modules');
            $table->foreign('module_option_id')->references('id')->on('module_options');
            $table->foreign('user_id')->references('id')->on('users');
        });
        Schema::table('permission_options', function (Blueprint $table) {
            $table->foreign('module_id')->references('id')->on('modules');
            $table->foreign('module_option_id')->references('id')->on('module_options');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropForeign(['employee_id']);
        });
        Schema::table('cities', function (Blueprint $table) {
            $table->dropForeign(['country_id']);
            $table->dropForeign(['state_id']);
            $table->dropForeign(['created_by']);
        });
        Schema::table('countries', function (Blueprint $table) {
            $table->dropForeign(['region_id']);
            $table->dropForeign(['subregion_id']);
            $table->dropForeign(['created_by']);
        });
        Schema::table('departments', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
        });
        Schema::table('designations', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
        });
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign(['city_id']);
            $table->dropForeign(['country_id']);
            $table->dropForeign(['created_by']);
            $table->dropForeign(['department_id']);
            $table->dropForeign(['designation_id']);
            $table->dropForeign(['state_id']);
        });
        Schema::table('modules', function (Blueprint $table) {
            $table->dropForeign(['module_group_id']);
        });
        Schema::table('regions', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
        });
        Schema::table('states', function (Blueprint $table) {
            $table->dropForeign(['country_id']);
            $table->dropForeign(['created_by']);
        });
        Schema::table('subregions', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropForeign(['region_id']);
        });
        Schema::table('users_activities', function (Blueprint $table) {
            $table->dropForeign(['module_id']);
            $table->dropForeign(['module_option_id']);
            $table->dropForeign(['user_id']);
        });
        Schema::table('permission_options', function (Blueprint $table) {
            $table->dropForeign(['module_id']);
            $table->dropForeign(['module_option_id']);
        });
    }
};
