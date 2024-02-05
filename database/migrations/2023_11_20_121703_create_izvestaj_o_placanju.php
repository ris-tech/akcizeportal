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
        Schema::create('izvestaj_o_placanju', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nalog_id');
            $table->string('broj');
            $table->date('datum');
            $table->unsignedBigInteger('banka_id');
            $table->decimal('iznos', $precision = 16, $scale = 2);
            $table->string('napomena');
            $table->timestamps();

            $table->foreign('nalog_id')->references('id')->on('nalozi');
            $table->foreign('banka_id')->references('id')->on('banke');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izvestaj_o_placanju');
    }
};
