<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('video');
            $table->string('nb_views')->default('0');
            $table->string('note')->default('0');
            $table->string('nb_note')->default('0');
            $table->string('tag1');
            $table->string('tag2');
            $table->string('tag3');
            $table->boolean('validated_by_admin')->default(false);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('post_statut')->references('statut')->on('statuts')->onDelete('cascade');
            $table->foreign('user_categorie')->references('categorie')->on('categories')->onDelete('cascade');
          /*  $table->foreign('user_tag1')->references('tag1')->on('tags')->onDelete('cascade');
            $table->foreign('user_tag2')->references('tag2')->on('tags')->onDelete('cascade');
            $table->foreign('user_tag3')->references('tag3')->on('tags')->onDelete('cascade');*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
