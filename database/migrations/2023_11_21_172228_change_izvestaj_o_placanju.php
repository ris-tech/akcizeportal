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
        Schema::table('izvestaj_o_placanju', function (Blueprint $table) {
            $table->string('broj')->nullable()->change();
            $table->string('datum')->nullable()->change();
            $table->unsignedBigInteger('banka_id')->nullable()->change();
            $table->decimal('iznos',16,2)->nullable()->change();
            $table->string('napomena')->nullable()->change();
            $table->string('vezni_dokument')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
