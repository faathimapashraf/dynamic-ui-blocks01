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
      

    Schema::create('ui_blocks', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('type'); // banner, card, list, stats
        $table->enum('status', ['Active', 'Inactive'])->default('Active');
        $table->integer('display_order')->default(0);
        $table->timestamps();
    });
}
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ui_blocks');
    }
};
