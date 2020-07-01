<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class IndexController extends Controller {
    //后台主页
    public function index() {
        //接力传递登录成功提示闪存
        session()->flash('msg', session('msg'));

        #如果不是超管，对应菜单
        //注意下面条件中is_menu是枚举的字符类型数字，那么条件必须字符串数字，不然当成1找不到选取了默认值"0"为结果（刚刚相反）
        if (auth()->user()->username != 'admin'){
            //获取用户对应的菜单权限
            $userAuth = auth()->user()->role->auths();
            $userAuth = $userAuth->where('is_menu','1')->get()->toArray();

            //将用户菜单权限按顶级内含次级处理
            $permission = subTree($userAuth);
        }else{
            //超管，返回所有菜单
            $permission = subTree(Permission::where('is_menu','1')->get()->toArray());
        }
        return view('admin.index.index',compact('permission'));
    }

    //欢迎页
    public function welcome() {
        return view('admin.index.welcome');
    }

    //退出登录
    public function logout() {
        auth()->logout();
        return redirect()->route('admin.login')->with('msg', '请重新登陆');
    }
}
