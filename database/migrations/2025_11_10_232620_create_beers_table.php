<?php

declare(strict_types=1);

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
        Schema::create('beers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('tagline')->nullable();
            $table->text('description');
            $table->date('first_brewed_at');
            $table->decimal('abv', 4, 1)->comment('Alcohol by Volume');
            $table->integer('ibu')->comment('International Bitterness Unit');
            $table->integer('ebc')->comment('European Brewery Convention');
            $table->decimal('ph', 3, 1)->comment('Ph');
            $table->integer('volume')->comment('Volume in ml');
            $table->text('ingredients')->nullable();
            $table->text('brewer_tips')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beers');
    }
};
