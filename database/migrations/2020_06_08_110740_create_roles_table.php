<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('role_name',100)->default('')->comment('角色名称');
            $table->timestamps();
            $table->softDeletes();
        });
        //权限与角色中间表
        Schema::create('role_permission',function (Blueprint $table){
            $table->unsignedInteger('rid')->default(0)->comment('角色ID');
            $table->unsignedInteger('pid')->default(0)->comment('权限ID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
        Schema::dropIfExists('role_permission');
    }
}
