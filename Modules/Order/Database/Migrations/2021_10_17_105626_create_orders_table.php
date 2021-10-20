<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();            $table->unsignedFloat('tax')->default(0);
            $table->foreignId('method_id')->constrained('order_methods')->cascadeOnDelete();
            $table->enum('status', ['pending', 'cancelled', 'processing', 'shipped', 'completed'])->default('pending');
            $table->unsignedFloat('price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
