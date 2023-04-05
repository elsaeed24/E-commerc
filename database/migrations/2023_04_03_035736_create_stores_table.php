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
        Schema::create('stores', function (Blueprint $table) {
            // id BIGINT UNSIGNED NOT_NULL AUTO_INCREMENT PRIMARY
            //$table->bigInteger('id')->unsigned()->autoIncrement()->primary();
            $table->id();

            // name VARCHAR(255) NOT_NULL
            $table->string('name');
            $table->string('slug')->unique();
            $table->char('currency',3)->default('USD');
            $table->char('locale',2)->default('en');
            $table->string('logo')->nullable();
            $table->text('description')->nullable();
            $table->enum('status',['active','inactive'])->default('active');
            // created_at (TIMESTAMP), updated_at (TIMESTAMP)
            $table->timestamps();
            // unique(accept nullable)  // primary

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
