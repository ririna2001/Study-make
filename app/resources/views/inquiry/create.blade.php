<head>
     <meta charset="UTF-8">
     <title>@yield('title','Studymake')</title>
     <link rel="stylesheet" href="{{ asset('css/app.css') }}">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<style>
    .container {
      max-width: 800px;
      margin: 50px auto;
      padding: 20px;
      background-color: #f9f9f9;
      border: 1px solid #ddd;
      }
</style>

@extends('layouts.app')
@section('content')
<div class="container text-center">
     <h2>お問い合わせフォーム</h2>
</div>

     {{-- バリデーションエラー --}}
     @if($errors->any())
       <div class="alert alert-danger">
          <ul>
             @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
             @endforeach
          </ul>
       </div>
     @endif

     {{-- フォーム --}}
<div class="container">
     <form action="{{ auth()->user()->isInstructor() 
    ? route('instructor.inquiries.confirm') 
    : route('inquiries.confirm') }}" method="POST">
        @csrf

        {{-- 名前 --}}
        <div class="mb-3">
            <larabel for="name" class="form-label text-start" >お名前</larabel>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        {{-- メールアドレス --}}
        <div class="mb-3">
            <larabel for="email" class="form-label">メールアドレス</larabel>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        {{-- お問い合わせ項目 --}}
        <div class="mb-3">
            <larabel for="category" class="form-label">お問い合わせ項目</larabel>
            <select name="category" id="category" class="form-control" required>
                <option value="">選択してください</option>
                <option value="使い方"{{ old('category') == '使い方' ? 'selected' : ''}}>使い方</option>
                <option value="不具合"{{ old('category') == '不具合' ? 'selected' : ''}}>不具合</option>
                <option value="その他"{{ old('category') == 'その他' ? 'selected' : ''}}>その他</option>
            </select>
        </div>

        {{-- お問い合わせ内容 --}}
        <div class="mb-3">
             <label for="content" class="form-label">お問い合わせ内容</label><br>
             <textarea name="content" id="content" class="form-control" rows="10" required>{{ old('content') }}</textarea>
        </div>

        {{-- ボタン --}}
        <div class="d-flex justify-content-between">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">戻る</a>
            <button type="submit" class="btn btn-primary">確認</button>
        </div>
     </form>
</div>
@endsection