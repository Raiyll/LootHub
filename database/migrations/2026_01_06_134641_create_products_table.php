<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 public function up()
{
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Contoh: "100 Diamonds"
        $table->string('game_name')->nullable(); // Contoh: "Mobile Legends"
        $table->integer('price');
        $table->integer('stock');
        $table->string('image')->nullable();
        $table->foreignId('category_id')->constrained();
        $table->softDeletes(); // Wajib buat fitur Soft Deletes lu
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
