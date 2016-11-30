<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAumListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aum_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->text('address');
            $table->string('gmap_lat');
            $table->string('gmap_lng');
            $table->string('contact');
            $table->string('header_path');
            $table->string('seo_name')->unique();
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
        Schema::drop('aum_lists');
    }
}
