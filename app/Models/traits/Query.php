<?php


namespace App\Models\traits;


use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

trait Query {
    public function search($request){
        /*
         * 以下的所有request参数都是ajax请求提交的
        */

        # 搜索条件
        //关键字
        $kw = $request->get('kw','');
        //日期,不用when了，有则有、没有则查找自设的一个时间段的所有值
        $datemin = !empty($request->datemin) ? $request->datemin : '2020-01-01';
        $datemax = !empty($request->datemax) ? $request->datemax : date('Y-m-d');
        $min = $datemin.' 00:00:00';
        $max = $datemax.' 23:59:59';
        //生成一个带或不带条件的User:: 头，下面就可以直接用
        $query = User::when($kw,function (Builder $query) use ($kw){
            $query->where('username','like',"%{$kw}%")
                ->orWhere('phone','like',"%{$kw}%")
                ->orWhere('email','like',"%{$kw}%");
        })
            ->whereBetween('created_at',[$min,$max]);

        # 获得排序数据
        //根据ajax数据发现了点击页面排序功能对应的列数
        $orderNum = $request->order[0]['column'];
        //根据列数在ajax数据找到要排序的字段名
        $orderName = $request->columns[$orderNum]['data'];

        # 提供查找的总记录数
        //必须写在offset和limit前面，因为这2个一经使用，后面所有sql语句都带有起始限制（尽管这句sql没有写）
        $num = $query->withTrashed()->count();
        # 根据ajax数据中的起始值，条数，排序字段名和升降序来查找具体数据
        $data = $query->offset($request->start)
            ->limit($request->length)
            ->orderBy($orderName,$request->order[0]['dir'])
            ->withTrashed()
            ->get();

        # 按照格式返回json数据
        /*
        draw: 客户端调用服务器端次数标识
        recordsTotal: 获取数据记录总条数
        recordsFiltered: 数据过滤后的总数量
        data: 获得的具体数据
        注意：recordsTotal和recordsFiltered都设置为记录的总条数
        */
        return  [
            'draw' 		 	 => $request->draw,
            'recordsTotal' 	 => $num,
            'recordsFiltered' => $num,
            'data'			=> $data
        ];
    }
}
