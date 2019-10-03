<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subject');
            $table->string('title');
            $table->integer('role_id')->nullable();
            $table->enum('email_type', ['new_article', 'assign_reviewer', 'resubmit_article', 'reviewer_feedback', 'accepted_articles_editor_feedback','minor_revisions_editor_feedback','major_revisions_editor_feedback','rejected_editor_feedback', 'publish_edition', 'new_user', 'change_password', 'update_user', 'new_order', 'success_order', 'cancel_order']);
            $table->text('body');
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
        Schema::dropIfExists('email_templates');
    }
}
