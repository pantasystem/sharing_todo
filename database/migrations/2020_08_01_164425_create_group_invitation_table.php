<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupInvitationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
         'invitation_group_id',
        'invitation_user_id',
        'expiration_date',
        'author_id',
        'is_accept'
         */
        Schema::create('group_invitation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->bigInteger('invitation_group_id');
            $table->bigInteger('invitation_user_id');
            $table->bigInteger('author_id');
            $table->boolean('is_accept');
            $table->dateTime('expiration_date')->nullable();

            $table->foreign('invitation_group_id')->references('id')->on('groups')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('invitation_user_id')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_invitation');
    }
}
