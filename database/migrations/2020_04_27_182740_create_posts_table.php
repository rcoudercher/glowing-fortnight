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
            $table->unsignedBigInteger('community_id')->nullable();
            $table->string('hash')->unique(); // 6 characters (alphanumeric, i.e. 62 possibilities each) = 56.800.235.584 possibilities
            $table->text('slug');
            $table->boolean('deleted')->default(0);
            $table->smallInteger('type')->default(0);
            $table->bigInteger('up_votes')->default(0);
            $table->bigInteger('down_votes')->default(0);
            $table->string('title');
            $table->text('content')->nullable();
            $table->text('image')->nullable();
            $table->text('link')->nullable();
            $table->smallInteger('status')->default(0); // moderation status
            $table->dateTime('moderated_at')->nullable();
            $table->unsignedBigInteger('moderated_by')->nullable();
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
