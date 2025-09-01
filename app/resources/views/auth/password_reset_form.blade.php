<!DOCTYPE html>
<html lang="ja">

 <head>
     <meta charset="UTF-8">
     <title>@yield('title','Studymake')</title>
     <link rel="stylesheet" href="{{ asset('css/app.css') }}">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

 <style>
    
    .container{
        max-width: 753px;
        height: 440px;
        margin: 50px auto;
        padding: 20px;
        background-color: #ffff;
        border: 1px solid #ddd;
        display: flex;
        flex-direction: column;
        justify-content: center;  
        align-items: center; 
        text-align: center;
    }

    .title{
        max-width: 350px;
        margin: 40px auto;
        background-color: #ffff;
        border: 5px solid #ddd;
        padding: 14px;
        text-align: center;
        display: flex;
        justify-content: center;  
        align-items: center;  
    }


     </style>
</head>

<body>
    <div class="title">
      <h2>パスワード再設定</h2>
    </div>
    
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

      <div class="container">
        <div>
            <label>新しいパスワード</label><br>
            <input type="password" name="password" required>
        </div>

        <div>
            <label>新しいパスワード（確認）</label><br>
            <input type="password" name="password_confirmation" required>
        </div>
      </div>

        <button type="submit">再設定</button>
    </form>
</body>
</html>
