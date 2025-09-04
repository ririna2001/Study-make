
<head>
    <meta charset="UTF-8">
    <title>@yield('title','Studymake')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

 <style>
        
    .titlebox{
        max-width: 800px;
        margin: 50px auto;
        padding: 20px;
        background-color: #ffff;
        border: 5px solid #ddd;
        text-align: center;
    }
    
    .search-box {
      max-width: 950px;
      margin: 50px auto;
      padding: 20px;
      border: 1px solid #ddd;
      text-align: center;
      }
    .content{
       text-align: center;
    }
    
    </style>
</head>

@extends('layouts.app')

@section('content')

<div class="titlebox">
 <h2>お問い合わせ一覧</h2>
</div>

{{-- フラッシュメッセージ（10秒で消える） --}}
@if (session('success'))
<div class="alert alert-success" id="flash-message">
    {{ session('success') }}
</div>
@endif

<div class="content">
        {{-- 検索フォーム --}}
    <form method="GET" action="{{route('admin.inquiries.index') }}">

        <div class="search-box">
            <div class="search-group mb-2">
                <label for="keyword">キーワード:</label>
                <input type="text" name="keyword" id="keyword" value="{{ request('keyword') }}" class="form-control" placeholder="名前・メールなど">
             </div>

            <div class="search-group mb-2">
                <label>対応状況：</label>
                <label><input type="radio" name="status" value="" {{ request('status') === null ? 'checked' : '' }}> すべて</label>
                <label><input type="radio" name="status" value="対応済" {{ request('status') === '対応済' ? 'checked' : '' }}> 対応済</label>
                <label><input type="radio" name="status" value="対応中" {{ request('status') === '対応中' ? 'checked' : '' }}> 対応中</label>
                <label><input type="radio" name="status" value="未対応" {{ request('status') === '未対応' ? 'checked' : '' }}> 未対応</label>
            </div>

            <div class="search-group mb-2">
                <label>お問い合わせ日：</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}">
                 〜
                <input type="date" name="date_to" value="{{ request('date_to') }}">
            </div>

            <div class="search-group mt-3">
                <a href="{{ route('admin.inquiries.index') }}" class="btn btn-secondary">リセット</a>
              <button type="submit" class="btn btn-primary">検索</button>
           </div>
       </div>
    </form>

    {{-- お問い合わせ一覧 --}}
    <table class="table table-bordered">
        <thead class="table-light">
            <tr">
                <th>お問い合わせID</th>
                <th>名前</th>
                <th>対応状況</th>
                <th>お問い合わせ日時</th>
                <th>メールアドレス</th>
                <th>お問い合わせ項目</th>
            </tr>
        </thead>
        <tbody>
         @forelse ($inquiries as $inquiry)
                <tr>
                    <td>
                       <a href="{{ route('admin.inquiries.show', $inquiry->id) }}">
                         {{ $inquiry->id }}
                       </a>
                    </td>
                    <td>{{ optional($inquiry->user)->name ?? optional($inquiry->instructor)->name ?? '未登録' }}</td>
                    <td>{{ $inquiry->status }}</td>
                    <td>{{ $inquiry->created_at->format('Y/m/d H:i') }}</td>
                    <td> {{ optional($inquiry->user)->email ?? optional($inquiry->instructor)->email ?? '未登録' }}</td>
                    <td>{{ $inquiry->category }}</td>
                </tr>
         @empty
                <tr>
                    <td colspan="6" class="text-center">該当するお問い合わせはありません。</td>
                </tr>
         @endforelse
        </tbody>
    </table>

     {{-- ページネーション --}}
    <div class="d-flex justify-content-center">
        {{ $inquiries->appends(request()->query())->links() }}
    </div>
</div>

<a href="{{ route('admin.mypage.index') }}" class="btn btn-secondary">戻る</a>

    <script>
    // ページ読み込み後、10秒でフェードアウトして非表示
    document.addEventListener('DOMContentLoaded', function () {
        const alert = document.querySelector('.alert-success');
        if (alert) {
            setTimeout(() => {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => {
                    alert.style.display = 'none';
                }, 500); 
            }, 10000); 
        }
    });
</script>
@endsection
