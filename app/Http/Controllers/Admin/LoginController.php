<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    //登录页面显示
    public function index() {
        if(auth()->check()) return redirect()->route('admin.index');
        return view('admin.login.index');
    }

    //登录验证处理
    public function login(LoginRequest $request) {
        if (auth()->attempt($request->only(['username','password']),true)){
            return redirect()->route('admin.index')->with('msg','登录成功');
        }else{
            return redirect()->back()->withErrors(['err'=>'登录信息不正确']);
        }
    }
}
