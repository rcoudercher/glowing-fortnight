<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // user who wrote this comment
            $table->unsignedBigInteger('post_id'); // post this comment is related to
            $table->unsignedBigInteger('community_id'); // community this comment is related to
            $table->unsignedBigInteger('parent_id')->nullable(); // comment this comment is related to. Null if root comment, i.e. is a direct reply to a post
            $table->text('content');
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
        Schema::dropIfExists('comments');
    }
}
