<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('aum_list_id')->unsigned();
            $table->string('name');
            $table->string('link');
            $table->timestamps();
        });
        Schema::table('menus', function (Blueprint $table) {
            $table->foreign('aum_list_id')
                  ->references('id')->on('aum_lists')
                  ->onDelete('restrict');
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('menus');
    }
}
