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
        <h2>{{ ucfirst($role) }} パスワード再設定</h2><br> 
    </div>
    
    @if (session('status'))
    <p style="color: green;">{{ session('status') }}</p>
    @endif
    
    @foreach ($errors->all() as $error)
    <p style="color: red;">{{ $error }}</p>
    @endforeach
    
    <div class="container">
      <h6 class="mb-5">パスワード設定用のリンクをお送りします</h6>
        <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <input type="hidden" name="role" value="{{ $role }}">
        <input type="email" name="email" class="form-control form-control-lg mb-3" placeholder="登録メールアドレス" required value="{{ old('email') }}">
    </div>

        <div class="d-flex justify-content-center mt-10">
           <a href="{{ $role === 'admin' ? url('/admin/login') : url('/login') }}" class="btn btn-secondary me-5">戻る</a>
           <button type="submit" class="btn btn-primary">再設定メールを送信</button>
        </div>
     </form>
</body>
</html>
