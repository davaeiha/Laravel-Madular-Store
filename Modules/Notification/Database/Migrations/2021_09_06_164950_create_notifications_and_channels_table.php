<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsAndChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->text('description');

            $table->timestamps();
        });

        Schema::create('channels', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->text('description');

            $table->timestamps();
        });

        Schema::create('channel_notification', function (Blueprint $table) {

            $table->unsignedBigInteger('notification_id');
            $table->foreign('notification_id')->references('id')->on('notifications')->onDelete('cascade');

            $table->unsignedBigInteger('channel_id');
            $table->foreign('channel_id')->references('id')->on('channels')->onDelete('cascade');

            $table->primary(['notification_id','channel_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('channel_notification');
        Schema::dropIfExists('channels');
        Schema::dropIfExists('notifications');
    }
}
