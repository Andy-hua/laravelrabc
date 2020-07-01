@if ($errors->any())
    @foreach($errors->all() as $error)
        <li style="color: red">{{ $error }}</li>
    @endforeach
@endif
@if (session()->has('msg'))
    <li style="color: green">{{ session('msg') }}</li>
@endif
