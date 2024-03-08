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
        Schema::create('item_imports', function (Blueprint $table) {
            $table->increments('item_id');
            $table->string('item_code', 20);
            $table->string('jan_code', 13);
            $table->string('item_name_1', 50);
            $table->string('item_name_2', 50)->nullable();
            $table->unsignedInteger('first_package_quantity');
            $table->unsignedInteger('total_order_quantity');
            $table->unsignedInteger('first_package_remaining');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_imports');
    }
};
