<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('interventions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bien_id');
            $table->unsignedBigInteger('technicien_id')->nullable();
            $table->string('type');
            $table->text('description')->nullable();
            $table->dateTime('date_intervention')->nullable();
            $table->string('statut')->default('planifiee');
            $table->decimal('cout', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interventions');
    }
};
