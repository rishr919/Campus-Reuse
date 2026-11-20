<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('description');
            $table->decimal('price', 12, 2)->nullable();
            $table->string('condition');
            $table->string('category');
            $table->string('campus_location')->nullable();
            $table->string('image_path')->nullable();
            $table->string('status')->default('tersedia');
            $table->timestamps();

            $table->index(['category', 'campus_location']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
