<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrsArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('slug')->unique();
            $table->integer('price')->nullable();
            $table->text('abstract');
            $table->text('excerpt');
            $table->string('submitted_document');
            $table->string('publish_document')->nullable();
            $table->enum('status', ['articles_under_review', 'accepted_articles', 'major_revisions', 'minor_revisions', 'rejected'])->default('articles_under_review');
            $table->string('editor_comments')->nullable();
            $table->integer('corresponding_author_id');
            $table->tinyInteger('notify')->default('0');
            $table->integer('article_category_id')->nullable();
            $table->integer('edition_id')->nullable();
            $table->string('unique_code');
            $table->tinyInteger('author_notify')->default('0');
            $table->integer('hits')->default('0');
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
        Schema::dropIfExists('articles');
    }
}
