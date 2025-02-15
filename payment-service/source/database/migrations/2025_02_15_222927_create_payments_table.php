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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->bigInteger("user_id")->index();
            $table->bigInteger("order_id")->index();
            $table->string("transaction_id", 20)->index();
            $table->string("processor_name")->index();
            $table->enum("status", ['pending','paid','failed','refunded'])->index()->default('pending');
            $table->string("notes", 1024)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
