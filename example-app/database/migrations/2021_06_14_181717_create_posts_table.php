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
            $table->string('tags');
            $table->string('video');
            $table->string('nb_views')->default('0');
            $table->string('note')->default('0');
            $table->string('nb_note')->default('0');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('categorie_id')->references('categorie')->on('users')->onDelete('cascade');
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
