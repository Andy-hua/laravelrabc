<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    //角色列表
    public function index()
    {
        $data = Role::paginate(2);
        return view('admin.role.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dump($request->post());
    }


    public function show(Role $role)
    {

    }

    //角色单个显示及修改，要传入模型
    public function edit(Role $role)
    {
        # 获取该角色的权限
        $myAuth = $role->auths->toArray();
        //多对多，上面结果是关联表合并中间表，只需要关联表的id
        //有值的话就取其id,无值则为空数组
        $myAuth = count($myAuth) > 0 ? array_column($myAuth,'id') : [];

        # 显示每个顶级权限名称包含的所有权限
        //使用递归
        $topAuth = subTree(Permission::get()->toArray());
        //笨方法
        //取顶级
/*        $topAuth = Permission::where('pid',0)->get()->toArray();
        //循环所有顶级数组，为数组中每个顶级权限添加一个名为sub、值为其下权限的数组
        foreach ($topAuth as $k=>$v){
            //查找权限表中pid等于该顶级权限的id的所有权限
            $topAuth[$k]['sub'] = Permission::where('pid',$v['id'])->get()->toArray();
        }*/

        //把该角色模型对象传到页面并传递到update中
        return view('admin.role.edit',compact('myAuth','topAuth','role'));
    }

    //角色权限修改处理
    public function update(Request $request, Role $role)
    {
        $role->auths()->sync($request->input('ids'));
        return ['status'=>200,'data'=>['msg'=>'分配权限成功']];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        //
    }
}
