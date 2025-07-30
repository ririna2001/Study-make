@if ($errors->has('login'))
    <div style="color: red;">{{ $errors->first('login') }}</div>
@endif

<form method="POST" action="{{ route($loginRoute) }}">
      @csrf

   <label for="email">メールアドレス</label><br>
   <input type="email" name="email" id="email" value="{{ old('email') }}" required><br>

   <label for="password">パスワード</label><br>
   <input type="password" name="password" id="password" required><br>

   <button type="submit">ログイン</button>
</form>