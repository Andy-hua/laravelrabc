@extends('layout.admin_user')

@section('content')
    <div class="page-container">
        <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l">
            <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
            <a href="{{ route('admin.permission.create') }}" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加权限</a></span>
        </div>
        @include('layout.errormsg')
        <div class="mt-20">
            <table class="table table-border table-bordered table-hover table-bg table-sort">
                <thead>
                <tr class="text-c">
                    <th width="80">ID</th>
                    <th width="100">权限名称</th>
                    <th width="100">路由别名</th>
                    <th width="100">是否为菜单</th>
                    <th width="40">操作</th>
                </tr>
                </thead>
                <tbody>
                @forelse($data as $item)
                    <tr class="text-c">
                        <td>{{ $item['id'] }}</td>
                        <td style="text-align: left">{{ $item['html'] }}{{ $item['name'] }}</td>
                        <td>{{ $item['routename'] }}</td>
                        <td>
                            @if ($item['is_menu'] == '0')
                                不是
                            @else
                                是
                            @endif
                        </td>
                        <td>修改和删除</td>
                    </tr>
                @empty
                    <tr class="text-c">
                        <td colspan="5">
                            暂无数据
                        </td>
                    </tr>
                @endforelse
                </tbody>

            </table>
        </div>
    </div>
@endsection
