<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('hash')->unique(); // 12 characters (alphanumeric, i.e. 62 possibilities each)
            $table->unsignedBigInteger('from_id');
            $table->unsignedBigInteger('to_id')->nullable(); // nullable for message drafts
            $table->unsignedBigInteger('ancestor_id')->nullable();
            $table->string('title');
            $table->text('content');
            $table->dateTime('read_at')->nullable();
            $table->dateTime('archived_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
