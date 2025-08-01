<!DOCTYPE html>
<html lang="ja">

<body>
    <h2>パスワード再設定</h2>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.reset.submit') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">
        <input type="hidden" name="role" value="{{ $role }}">

        <div>
            <label>新しいパスワード</label><br>
            <input type="password" name="password" required>
        </div>

        <div>
            <label>新しいパスワード（確認）</label><br>
            <input type="password" name="password_confirmation" required>
        </div>

        <button type="submit">再設定</button>
    </form>
</body>
</html>
