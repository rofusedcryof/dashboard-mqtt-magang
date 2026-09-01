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
    Schema::create('milling_oees', function (Blueprint $table) {
        $table->id();
        $table->integer('hari');
        $table->integer('setup_time_mnt');
        $table->integer('operating_time_mnt');
        $table->integer('produk_liter');
        $table->integer('downtime_jam');
        $table->string('keterangan')->nullable();
        $table->decimal('availability', 5, 2);
        $table->decimal('performance', 5, 2);
        $table->decimal('quality_rate', 5, 2);
        $table->decimal('oee', 5, 2);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('milling_oees');
    }
};
