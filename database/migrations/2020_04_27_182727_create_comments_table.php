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
            $table->unsignedBigInteger('ancestor_id')->nullable(); // null if root comment, i.e. is a direct reply to a post
            $table->unsignedBigInteger('parent_id')->nullable(); // comment this comment is a reply to, parent comment can be a child comment
            $table->string('hash')->unique(); // 7 characters (alphanumeric, i.e. 62 possibilities each) = 3.521.614.606.208 possibilities
            $table->bigInteger('up_votes')->default(0);
            $table->bigInteger('down_votes')->default(0);
            $table->text('content');
            $table->boolean('deleted')->default(0);
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
        Schema::dropIfExists('comments');
    }
}
