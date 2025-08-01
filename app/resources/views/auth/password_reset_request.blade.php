<!DOCTYPE html>
<html lang="ja">

<body>
    <h2>{{ ucfirst($role) }} パスワード再設定</h2><br>
    <h2>パスワード設定用のリンクをお送りします</h2>

    @if (session('status'))
        <p style="color: green;">{{ session('status') }}</p>
    @endif

    @foreach ($errors->all() as $error)
        <p style="color: red;">{{ $error }}</p>
    @endforeach

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <input type="hidden" name="role" value="{{ $role }}">
        <input type="email" name="email" placeholder="登録メールアドレス" required value="{{ old('email') }}">
        <button type="submit">再設定メールを送信</button>
    </form>

    <p><a href="{{ $role === 'admin' ? url('/admin/login') : url('/login') }}">ログインに戻る</a></p>
</body>
</html>