<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNullableWarnings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('warnings', function (Blueprint $table) {
            $table->bigInteger('forum_id')->unsigned()->nullable()->change();
            $table->dropforeign('warnings_forum_id_foreign');
            $table->foreign('forum_id')
                ->references('id')
                ->on('forums')
                ->onDelete('set null');


            $table->bigInteger('forum_comment_id')->unsigned()->nullable()->change();
            $table->dropforeign('warnings_forum_comment_id_foreign');
            $table->foreign('forum_comment_id')
                ->references('id')
                ->on('forum_comments')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table->bigInteger('forum_id')->unsigned()->change();
        $table->bigInteger('forum_comment_id')->unsigned()->change();
    }
}
