@extends('layout.admin_user')
@section('content')
    <form name="myform" method="post">
        @csrf
        @method('PUT')
        <dl>
            @foreach($topAuth as $item)
                <dt>
                    <input type="checkbox" name="ids[]" value="{{ $item['id'] }}"
                           @if (in_array($item['id'],$myAuth)) checked @endif>
                    {{ $item['name'] }}
                </dt>
                @foreach($item['sub'] as $val)
                    <dd>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        
                        <input type="checkbox" name="ids[]" value="{{ $val['id'] }}"
                               @if (in_array($val['id'],$myAuth)) checked @endif>
                        {{ $val['name'] }}
                    </dd>
                @endforeach
            @endforeach
        </dl>
        <input id="authSave" type="button" value="分配权限">
    </form>
@endsection
@section('js')
    <script>
        $(function () {
            $('#authSave').click(function () {

                let url = "{{ route('admin.role.update',$role) }}"
                let fd = new FormData(document.myform)

                $.ajax({
                    url,
                    type: 'POST',
                    ache: false,              // 不缓存
                    processData: false,       // jQuery不要去处理发送的数据
                    contentType: false,       // jQuery不要去设置Content-Type请求头
                    data: fd,                 //设置了上面2个后，这里只能给formdata对象，其他键值对参数jquery不会处理
                    dataType: 'json',
                    success: (ret) => {
                        if (ret.status == 200) {
                            alert(ret.data.msg)
                            layer_close()
                        }
                    }
                })
            })
        })
    </script>
@endsection



