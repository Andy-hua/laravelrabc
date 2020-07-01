@extends('layout.admin_user')

@section('content')
    <div class="page-container">
        @include('layout.errormsg')
        <div class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="l"><a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> <a href="javascript:;" onclick="member_add('添加用户','member-add.html','','510')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加用户</a></span>
            <span class="r">共有数据：<strong>88</strong> 条</span></div>
        <div class="mt-20">
            <table class="table table-border table-bordered table-hover table-bg table-sort">
                <thead>
                <tr class="text-c">
                    <th width="80">ID</th>
                    <th width="100">角色名称</th>
                    <th width="40">操作</th>
                </tr>
                </thead>
                <tbody>
                @forelse($data as $item)
                    <tr class="text-c">
                        <td>{{ $item->id }}</td>
                        <td>
                            <u style="cursor:pointer" class="text-primary" onclick="layer_show('{{ $item->role_name }}的权限','{{ route('admin.role.edit',$item) }}','800','500')">{{ $item->role_name }}</u>
                        </td>
                        <td>修改和删除</td>
                    </tr>
                @empty
                    <tr class="text-c">
                        <td colspan="3">
                            暂无数据
                        </td>
                    </tr>
                @endforelse
                
                </tbody>
            
            </table>
        </div>
        {{ $data->appends(request()->except(['page']))->links() }}
    </div>
@endsection
