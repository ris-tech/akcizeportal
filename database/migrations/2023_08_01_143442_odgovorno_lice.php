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
        Schema::create('odgovorno_lice', function (Blueprint $table) {
            $table->id();
            $table->integer('pol');
            $table->string('ime', 64);
            $table->string('prezime', 64);
            $table->string('telefon', 32);
            $table->string('email', 128)->nullable();
            $table->string('jmbg', 13);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('odgovorno_lices');
    }
};
