<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\traits\Query;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use Query;

    //管理员列表展示
    public function index(Request $request) {
        $dateData = ['datemin'=>'2020-01-01','datemax'=>date('Y-m-d')];
        return view('admin.user.index',compact('dateData'));
    }
    //ajax请求分页数据
    public function list(Request $request) {
        return $this->search($request);
    }

    //分配角色展示
    public function role(User $user) {
        $roles = Role::get();
        return view('admin.user.role',compact('user','roles'));
    }
    //分配角色处理
    public function roleSave(Request $request,User $user) {
        $user->update(["role_id"=>$request->ids]);
        return redirect(route('admin.user.index'))->with('msg','分配角色成功');
    }

    //新增
    public function add() {

    }
    //新增处理
    public function addSave(Request $request) {

    }

    //更新
    public function edit(Request $request,int $id) {

    }
    //更新处理
    public function editSave(Request $request,int $id) {

    }

    //删除
    public function del(Request $request,User $user) {
        $user->delete();
        return ['status'=>200,'msg'=>'已停用'];
    }

}
