<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->text('name')->comment('名称');

            $table->text('icon')->nullable()->comment('图标');

            $table->unsignedBigInteger('sort')->comment('顺序');

            $table->unsignedBigInteger('pid')->nullable()->comment('父分类ID');
            $table->foreign('pid')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
