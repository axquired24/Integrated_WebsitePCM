<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllFks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('article_categories', function (Blueprint $table) {
            $table->foreign('aum_list_id')
                  ->references('id')->on('aum_lists')
                  ->onDelete('restrict');
        });

        Schema::table('articles', function (Blueprint $table) {
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('restrict');
            $table->foreign('article_category_id')
                  ->references('id')->on('article_categories')
                  ->onDelete('restrict');
        });

        // Schema::table('users', function (Blueprint $table) {
        //     $table->foreign('aum_list_id')
        //           ->references('id')->on('aum_lists')
        //           ->onDelete('restrict');
        // });

        Schema::table('pages', function (Blueprint $table) {
            $table->foreign('aum_list_id')
                  ->references('id')->on('aum_lists')
                  ->onDelete('restrict');
        });

        Schema::table('gallery_categories', function (Blueprint $table) {
            $table->foreign('aum_list_id')
                  ->references('id')->on('aum_lists')
                  ->onDelete('restrict');
        });

        Schema::table('galleries', function (Blueprint $table) {
            $table->foreign('gallery_category_id')
                  ->references('id')->on('gallery_categories')
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
        Schema::table('article_categories', function (Blueprint $table) {
            $table->dropForeign('article_categories_aum_list_id_foreign');
        });

        Schema::table('articles', function (Blueprint $table) {
            $table->dropForeign('articles_user_id_foreign');
            $table->dropForeign('articles_article_category_id_foreign');
        });

        // Schema::table('users', function (Blueprint $table) {
        //     $table->dropForeign('users_aum_list_id_foreign');
        // });

        Schema::table('pages', function (Blueprint $table) {
            $table->dropForeign('pages_aum_list_id_foreign');
        });

        Schema::table('gallery_categories', function (Blueprint $table) {
            $table->dropForeign('gallery_categories_aum_list_id_foreign');
        });

        Schema::table('galleries', function (Blueprint $table) {
            $table->dropForeign('galleries_gallery_category_id_foreign');
        });
    }
}
