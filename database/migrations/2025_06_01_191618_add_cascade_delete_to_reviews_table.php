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
        Schema::table('reviews', function (Blueprint $table) {
            // Удаляем старое ограничение
            $table->dropForeign(['product_id']);

            // Создаем новое с каскадным удалением
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['product_id']);

            // Восстанавливаем оригинальное ограничение
            $table->foreign('product_id')
                ->references('id')
                ->on('products');
        });
    }
};
