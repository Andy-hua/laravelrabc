@extends('layout.admin_user')
@section('content')
    <div class="page-container">
        @include('layout.errormsg')
        <div class="text-c"> 日期范围：
            <input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}' })" id="datemin" value="{{ $dateData['datemin'] }}" class="input-text Wdate" style="width:120px;">
            -
            <input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d' })"  id="datemax" value="{{ $dateData['datemax'] }}" class="input-text Wdate" style="width:120px;">
            <input type="text" class="input-text" style="width:250px" placeholder="输入会员名称、电话、邮箱" id="kw">
            <button type="button" class="btn btn-success radius" id="searchbtn" name=""><i class="Hui-iconfont">&#xe665;</i> 搜用户
            </button>
        </div>
        <div class="cl pd-5 bg-1 bk-gray mt-20"><span class="l"><a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> <a href="javascript:;" onclick="member_add('添加用户','member-add.html','','510')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加用户</a></span> <span class="r">共有数据：<strong>88</strong> 条</span></div>
        <div class="mt-20">
            <table class="table table-border table-bordered table-hover table-bg table-sort">
                <thead>
                <tr class="text-c">
                    <th width="25"><input type="checkbox" name="" value=""></th>
                    <th width="80">ID</th>
                    <th width="100">用户名</th>
                    <th width="130">加入时间</th>
                    <th width="70">状态</th>
                    <th width="100">操作</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(function () {
            //初始化，有返回值的，接收一下
            var datatable = $('.table-sort').dataTable({
                //默认哪列排序,0开始。箭头会高亮
                order:[[1,'asc']],
                //设置哪列不排序
                columnDefs:[
                    {targets:[0,5],orderable:false}
                ],
                //提供可选每页显示记录数
                "lengthMenu": [ 1, 2, 3, 4, 5 ],
                //隐藏客户端搜索,只对单次响应本地搜索，一般不用，用服务端分页
                searching:false,
                //显示正在处理状态
                processing:true,

                // 服务端分页
                // ①开启服务器模式
                serverSide: true,
                //②ajax请求数据
                ajax: {
                    // 请求地址
                    url: '{{ route("admin.user.list") }}',
                    // 请求方式 get/post
                    type: 'GET',
                    // 请求的参数
                    // 两者写法效果一致  但是它用于搜索
                    data(d) {
                        d.kw = $.trim($('#kw').val())
                        d.datemax = $('#datemax').val()
                        d.datemin = $('#datemin').val()
                    }
                },
                //③规定每列如何显示
                columns:[
                    {'data':'aaa',defaultContent: '',className:"text-c"},
                    {'data':'id',className:"text-c"},
                    {'data':'username',className:"text-c"},
                    {'data':'created_at',className:"text-c"},
                    {'data':'deleted_at',className:"text-c"},
                    {'data':'bbb',defaultContent: '',className:"text-c"},
                ],
                //④回调函数
                createdRow(row,data){
                    /* 全选复选框 */
                    //默认值有变化，移到这里，把每行的id赋值给value
                    let html = `<input type="checkbox" value="${data.id}" name="id[]">`
                    //要转化为jquery对象才能用jquery的方法获取第一列并改变html
                    $(row).find('td:eq(0)').html(html)

                    /* 用户是否禁用 */
                    //data.id是添加自定义属性的意思，和input的value效果一样
                    let html1 = `<span data-id="${data.id}" class="label label-success radius">已启用</span>`
                    if(data.deleted_at != null){
                        html1 = `<span data-id="${data.id}" class="label label-warning radius">停用</span>`
                    }
                    $(row).find('td:eq(4)').html(html1)

                    /* 修改与删除 */
                    //这里面不要用blade的route方法了，太复杂
                    let html2 = `<div class="btn-group">
                                    <a href="/admin/user/role/${data.id}" class="btn size-S btn-primary-outline radius">分配角色</a>
                                    <a href="/admin/user/edit/${data.id}" class="btn size-S btn-primary-outline radius">修改</a>
                                    <a href="/admin/user/del/${data.id}" class="btn size-S btn-primary-outline radius delbtn">删除</a>
                                </div>`
                    $(row).find('td:eq(5)').html(html2)
                }

            });

            //点击搜索让datatable重新加载一次
            $('#searchbtn').click(()=>{
                datatable.api().ajax.reload()
            })

            // 删除
            // 阻止a标签默认行为并点击提交ajax
            // 因为每个删除a标签都不是事实存在的，而table是事实存在，用事件委托
            $('.table-sort').on('click','.delbtn',function(evt){
                //阻止跳转
                evt.preventDefault()

                var url = $(this).attr('href')
                $.ajax({
                    url,
                    type:'DELETE',
                    data:{
                        _token:"{{ csrf_token() }}"
                    },
                    dataType:'json',
                    //这里用箭头函数，指向最外层的a链接，使this指向a链接，不然的话this指向这个ajax请求
                    success: ret => {
                        //$(this).parents('tr').remove()
                        datatable.api().ajax.reload()

                        //这个后台管理模板的一个window加强版对象（如layer.alert）
                        // layer.msg可以弹出信息提示,icon 5是苦脸红色 6是笑脸绿色
                        layer.msg(ret.msg,{time:2000,icon:6})
                    }
                })
            })

        })
    </script>
@endsection
