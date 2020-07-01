<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="{{ route('admin.user.role',$user) }}" method="post">
        @csrf
        <ul>
            @foreach($roles as $item)
                <li>
                    <input type="radio" name="ids" @if ($item->id == $user->role_id) checked @endif value="{{$item->id}}">{{$item->role_name}}
                </li>
            @endforeach
        </ul>
        <input type="submit" value="分配角色">
    </form>
</body>
</html>
