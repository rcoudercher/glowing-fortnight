<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('communities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('creator_id')->nullable();
            $table->smallInteger('type')->default(1); // 1: public, 2: restricted, 3: private
            $table->boolean('mod_members')->default(0); // whether users can join this community freely or only upon request
            $table->boolean('mod_posts')->default(0); // wheter new posts are moderated or not
            $table->boolean('mod_comments')->default(0); // wheter new comments are moderated or not
            $table->string('hash')->unique(); // unique string community identifier       
            $table->string('name')->unique();
            $table->string('display_name')->unique();
            $table->text('title')->nullable();	
            $table->text('description')->nullable();
            $table->text('submission_text')->nullable();
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
        Schema::dropIfExists('communities');
    }
}
