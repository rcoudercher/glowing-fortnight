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
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('community_id')->nullable(); // id of the related community
            $table->boolean('notification')->default(0); // notifies post activity to the author
            $table->boolean('public')->default(1); // remains false until community moderator accepts post
            $table->string('hash')->unique(); // 6 characters (alphanumeric, i.e. 62 possibilities each) = 56.800.235.584 possibilities
            $table->text('slug');
            $table->boolean('deleted')->default(0);
            $table->string('title');
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
        Schema::dropIfExists('posts');
    }
}
