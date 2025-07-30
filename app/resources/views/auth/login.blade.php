<head>
     <meta charset="UTF-8">
     <title>@yield('title','Studymake')</title>
     <link rel="stylesheet" href="{{ asset('css/app.css') }}">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>


<style>
    .container {
      max-width: 950px;
      margin: 50px auto;
      padding: 20px;
      background-color: #f9f9f9;
      border: 1px solid #ddd;
      text-align: center;
      }
</style>

<div class="container">
    <h2>ログイン画面</h2>
</div>

<div class="container">
 @if ($errors->has('login'))
    <div style="color: red;">{{ $errors->first('login') }}</div>
 @endif

 <form method="POST" action="{{ route($loginRoute) }}">
      @csrf

   <label for="email">メールアドレス</label><br>
   <input type="email" name="email" id="email" value="{{ old('email') }}" required><br>

   <label for="password">パスワード</label><br>
   <input type="password" name="password" id="password" required><br>

   {{-- パスワード再設定リンク --}}
    <div class="mt-3">
        パスワードをお忘れの方は<a href="{{ route('password.request') }}">こちら</a>から
    </div>
    
    {{-- 新規登録リンク --}}
    <div class="mt-3">
        アカウント登録がまだの方は<a href="{{ route('register.form') }}">こちら</a>から
    </div>

   <button type="submit">ログイン</button>
  </form>

</div>
