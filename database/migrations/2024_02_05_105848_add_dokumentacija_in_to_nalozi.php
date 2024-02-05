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
        Schema::table('nalozi', function (Blueprint $table) {
            $table->date('dokumentacija_in')->nullable();
            $table->string('dokumentacija_in_komentar')->nullable();
            $table->date('dokumentacija_out')->nullable();
            $table->string('dokumentacija_out_komentar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nalozi', function (Blueprint $table) {
            //
        });
    }
};
