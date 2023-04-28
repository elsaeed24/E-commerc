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
        Schema::create('categories_i18ns', function (Blueprint $table) {
           $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
           $table->string('locale',2);
           $table->string('name');
           $table->text('description')->nullable();

           $table->primary(['category_id','locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories_i18ns');
    }
};
