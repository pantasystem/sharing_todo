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
            $table->bigIncrements('id');
            $table->timestamps();
            $table->bigInteger('reply_to_id')->nullable();
            $table->bigInteger('author_id');
            $table->bigInteger('todo_id');
            $table->text('text')->index();
            $table->foreign('todo_id')
                ->references('id')->on('todos')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('author_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            
            /*$table->foreign('reply_to_id')->references('id')->on('comments')
                ->onDelete('cascade')
                ->onUpdate('cascade');*/
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
