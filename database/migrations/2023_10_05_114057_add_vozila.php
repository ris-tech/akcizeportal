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
        Schema::table('vozila', function (Blueprint $table) {
            $table->string('saobracajna', 64)->nullable()->after('do');
            $table->date('saobracajna_od')->nullable()->after('saobracajna');
            $table->date('saobracajna_do')->nullable()->after('saobracajna_od');
            $table->string('broj_sasice', 20)->nullable()->after('saobracajna_do');
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
