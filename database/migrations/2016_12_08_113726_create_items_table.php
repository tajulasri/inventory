<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('identifier')->nullable();
            $table->text('item_slug')->nullable();
            $table->string('image')->nullable();
            $table->decimal('buy',10,2)->default(0);
            $table->decimal('sell',10,2)->default(0);
            $table->integer('balance')->default(0);
            $table->integer('status')->default(1);
            $table->integer('category_id')->default(0);
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
        Schema::dropIfExists('items');
    }
}
