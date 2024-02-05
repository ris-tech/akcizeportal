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
        Schema::create('izvestaj_po_vozilu', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nalog_id');
            $table->unsignedBigInteger('vozilo_id');
            $table->char('predjene_km', 8);
            $table->timestamps();

            $table->foreign('nalog_id')->references('id')->on('nalozi');
            $table->foreign('vozilo_id')->references('id')->on('vozila');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izvestaj_po_vozilu');
    }
};
