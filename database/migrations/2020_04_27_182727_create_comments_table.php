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
            $table->unsignedBigInteger('user_id')->nullable(); // user who wrote this comment
            $table->unsignedBigInteger('post_id')->nullable(); // post this comment is related to
            $table->unsignedBigInteger('community_id')->nullable(); // community this comment is related to
            $table->unsignedBigInteger('parent_id')->nullable(); // comment this comment is related to. Null if root comment, i.e. is a direct reply to a post
            $table->string('hash')->unique(); // 7 characters (alphanumeric, i.e. 62 possibilities each) = 3.521.614.606.208 possibilities
            $table->text('content');
            $table->boolean('deleted')->default(0);
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
