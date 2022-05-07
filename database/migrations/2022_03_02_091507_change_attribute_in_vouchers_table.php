<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeAttributeInVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vouchers', function (Blueprint $table) {
            $table->dropForeign('vouchers_user_id_foreign');
            $table->dropColumn('user_id');
            $table->unique('code');
            $table->date('start_date')->change();
            $table->date('end_date')->change();
            $table->unsignedBigInteger('quantity')->change();
            $table->unsignedBigInteger('value')->change();
            $table->unsignedBigInteger('condition_min_price')->change();
            $table->unsignedBigInteger('maximum_reduction')->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vouchers', function (Blueprint $table) {
            $table->foreignID('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->dropUnique('code');
            $table->string('quantity');
            $table->string('value');
            $table->string('condition_min_price');
            $table->string('maximum_reduction');
            $table->datetime('start_date');
            $table->datetime('end_date');
        });
    }
}
