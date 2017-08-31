<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminLogin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_admin_login', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username');
            $table->string('email');
            $table->string('password');
            $table->date('date_update');
            $table->date('date_create');
            $table->enum('status', array('active', 'inactive'));
            $table->text('modules_permission');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('profile_pic');
            $table->string('profile_edit_pic');
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tbl_admin_login');
    }
}
