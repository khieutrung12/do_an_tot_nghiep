<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Users extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignID('role_id')->references('id')->on('roles')->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('avatar');
            $table->string('phone');
            $table->string('address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('phone', 'avatar', 'role_id', 'address')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropForeign('role_id');
                $table->dropColumn(['phone', 'avatar', 'role_id', 'address']);
            });
        }
    }
}
