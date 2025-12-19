<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coffees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2);
            $table->boolean('available')->default(true);
            $table->text('image')->nullable(); // Base64 или путь
            $table->foreignId('size_id')->constrained('size_coffees');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coffees');
    }
};