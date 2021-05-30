<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('order_id')->comment('订单ID');
            $table->foreign('order_id')->references('id')->on('orders');

            $table->unsignedBigInteger('product_id')->comment('商品ID');
            $table->foreign('product_id')->references('id')->on('products');

            $table->string('name')->comment('商品名称快照');
            $table->json('preview')->comment('商品预览图快照');
            $table->json('code')->comment('代码快照');
            $table->decimal('price')->comment('商品价格快照');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
