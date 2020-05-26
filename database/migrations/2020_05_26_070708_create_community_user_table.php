<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunityUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('community_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('community_id');
            $table->boolean('admin')->default(0);
            $table->smallInteger('status')->default(0);
            $table->dateTime('moderated_at')->nullable();
            $table->unsignedBigInteger('moderated_by')->nullable();
            $table->unique(['user_id', 'community_id']);
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
        Schema::dropIfExists('community_user');
    }
}
