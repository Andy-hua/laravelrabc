<?php

use App\Http\Controllers\Admin\IndexController;

Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>['checklogin']],function (){
    //登录显示
    Route::get('login','LoginController@index')->name('admin.login');
    //登录处理
    Route::post('login','LoginController@login')->name('admin.login');
    //后台主页
    Route::get('index','IndexController@index')->name('admin.index');
    //后台欢迎页
    Route::get('welcome','IndexController@welcome')->name('admin.welcome');
    //退出登录
    Route::get('logout','IndexController@logout')->name('admin.logout');

    # 管理员列表
    //列表展示
    Route::get('user/index','UserController@index')->name('admin.user.index');
    //ajax请求服务器分页数据
    Route::get('user/list','UserController@list')->name('admin.user.list');

    //新增展示及处理
    Route::get('user/add','UserController@add')->name('admin.user.add');
    Route::post('user/add','UserController@addSave')->name('admin.user.add');
    //修改展示及处理
    Route::get('user/edit/{id}','UserController@edit')->name('admin.user.edit')->where(['id'=>'\d+']);
    Route::put('user/edit/{id}','UserController@editSave')->name('admin.user.edit')->where(['id'=>'\d+']);
    //删除
    Route::delete('user/del/{user}','UserController@del')->name('admin.user.del');

    //分配角色展示及处理
    Route::get('user/role/{user}','UserController@role')->name('admin.user.role');
    Route::post('user/role/{user}','UserController@roleSave')->name('admin.user.role');

    # 角色管理
    Route::resource('role','RoleController',['as'=>'admin']);

    # 权限管理
    Route::resource('permission','PermissionController',['as'=>'admin']);

});
