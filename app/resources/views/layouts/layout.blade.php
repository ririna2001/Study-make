<!DOCTYPE html>
<html lang="ja">
<head>
     <meta charset="UTF-8">
     <title>@yield('title','Studymake')</title>
     <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
  {{-- -共通ヘッダー --}}
  <header style="background: #f8f8f8; padding: 10px 20px;"></header>
     <nav style="display: flex; gap: 10px;">
        <a href="{{ route('home') }}">トップ</a>
        <a href="{{ route('mypage') }}">マイページ</a>
        <a href="{{ route('contact') }}">お問い合わせ</a>
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit">ログアウト</button>
        </form>
     </nav>
   </header>

   <main class="container" style="padding: 20px;">
    @yiled('content')
   </main> 
</body>
</html>