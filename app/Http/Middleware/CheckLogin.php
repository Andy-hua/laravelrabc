<?php

namespace App\Http\Middleware;

use App\Exceptions\AuthException;
use Closure;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //当前路由名称
        $currentRName = $request->route()->getName();
        //储存的是无需登录就能访问的、直接跳过的路由
        $path = [
            'admin.login',
        ];
        if (!in_array($currentRName,$path)){

            # 判断是否登录
            if (!auth()->check()){
                session()->flush();
                return redirect()->route('admin.login')->withErrors(['err'=>'请登录']);
            }

            # 判断权限
            //获取当前用户所拥有的权限的路由别名
            $data = array_column(auth()->user()->role->auths->toArray(),'routename');
            //如首页、欢迎页、登出这些每个用户都有的权限路由，可以把它加入到用户权限数组中
            //由于这些公共路由要登录才能展示，所以不应该写在上面的path
            //合并查询权限和公共权限
            $data = array_merge($data,config('publicAuth'));

            //如果当前路由不在用户拥有路由别名数组中,即没权限 并且 admin超管要有所有的权限
            if(auth()->user()->username != 'admin' && !in_array($currentRName,$data)){
                throw new AuthException('error');
            }

        }
        return $next($request);
    }
}
