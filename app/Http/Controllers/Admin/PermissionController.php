<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    //权限列表
    public function index()
    {
        //最好不做分页，不然后面做层级容易出问题
        $data = treeLevel(Permission::get()->toArray());
        return view('admin.permission.index',compact('data'));
    }

    //添加权限展示
    public function create()
    {
        //顶级菜单选择框展示
        $data = Permission::where('pid',0)->get();
        return view('admin.permission.create',compact('data'));
    }

    //添加权限验证
    public function store(PermissionRequest $request)
    {
        $model = Permission::create($request->post());
        return redirect()->route('admin.permission.index')->with('msg','添加权限【'.$model->name.'】成功');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        //
    }
}
