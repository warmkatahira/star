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
        Schema::create('order_imports', function (Blueprint $table) {
            $table->increments('order_id');
            $table->string('item_code', 20);
            $table->unsignedInteger('quantity');
            $table->string('order_file_name', 200);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_imports');
    }
};
