<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('biens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categorie_id')
                ->constrained('categories')
                ->cascadeOnDelete();
            $table->string('nom');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->decimal('valeur', 15, 2)->default(0);
            $table->date('date_acquisition')->nullable();
            $table->string('etat')->default('bon');
            $table->string('localisation')->nullable();
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('biens');
    }
};
