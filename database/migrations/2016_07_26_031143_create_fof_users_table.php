<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFofUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fof_users', function (Blueprint $table) {
            $table->increments('fuid');
            $table->timestamps();

            $table->tinyinteger('type'); // 类型：1.个人；2.企业
            $table->string('name'); // 姓名
            $table->string('id_number');    // 证件号码
            $table->string('id_number_last_6'); // 证件号码后6位
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('fof_users');
    }
}
