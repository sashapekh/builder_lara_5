<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbTreeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_tree', function (Blueprint $table) {
            $table->collation = 'utf8_general_ci';
            $table->charset = 'utf8';

            $table->increments('id');
            $table->unsignedInteger('parent_id')->nullable();
            $table->integer('lft');
            $table->integer('rgt');
            $table->integer('depth');
            $table->string('title');
            $table->text('description');
            $table->string('slug');
            $table->string('template', 120);
            $table->string('picture');
            $table->text('additional_pictures');
            $table->tinyInteger('is_active');
            $table->string('seo_title');
            $table->string('seo_description');
            $table->string('seo_keywords');
            $table->tinyInteger('is_show_in_menu');
            $table->tinyInteger('is_show_in_footer_menu');
            $table->timestamps();

            $table->index('lft');
            $table->index('rgt');

            $table->foreign('parent_id')->references('id')->on('tb_tree')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tb_tree');
    }
}
