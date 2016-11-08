<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('aum_list_id')->unsigned();
            $table->string('filename');
            $table->string('title');
            $table->timestamps();
        });
        Schema::table('files', function (Blueprint $table) {
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
        Schema::drop('files');
    }
}
