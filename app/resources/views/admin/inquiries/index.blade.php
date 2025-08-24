@extends('layouts.app')

@section('content')
<div class="container">

     <h2>お問い合わせ一覧</h2>

        {{-- フラッシュメッセージ（10秒で消える） --}}
    @if (session('success'))
        <div class="alert alert-success" id="flash-message">
            {{ session('success') }}
        </div>
    @endif

        {{-- 検索フォーム --}}
    <form method="GET" action="{{route('admin.inquiries.index') }}">
            <div class="form-group mb-2">
                <label for="keyword">キーワード</label>
                <input type="text" name="keyword" id="keyword" value="{{ request('keyword') }}" class="form-control" placeholder="名前・メールなど">
             </div>

            <div class="form-group mb-2">
                <label>対応状況：</label>
                <label><input type="radio" name="status" value="" {{ request('status') === null ? 'checked' : '' }}> すべて</label>
                <label><input type="radio" name="status" value="対応済" {{ request('status') === '対応済' ? 'checked' : '' }}> 対応済</label>
                <label><input type="radio" name="status" value="対応中" {{ request('status') === '対応中' ? 'checked' : '' }}> 対応中</label>
                <label><input type="radio" name="status" value="未対応" {{ request('status') === '未対応' ? 'checked' : '' }}> 未対応</label>
            </div>

            <div class="form-group mb-2">
                <label>お問い合わせ日：</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}">
                 〜
                <input type="date" name="date_to" value="{{ request('date_to') }}">
            </div>

            <div class="form-group mt-3">
              <button type="submit" class="btn btn-primary">検索</button>
              <a href="{{ route('admin.inquiries.index') }}" class="btn btn-secondary">リセット</a>
           </div>
    </form>

    {{-- お問い合わせ一覧 --}}
    <table class="table table-bordered">
        <thead>
            <tr>
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
                       <a href="{{ route('admin.inquiries.show', $inquiries->id) }}">
                         {{ $inquiry->id }}
                       </a>
                    </td>
                    <td>{{ $inquiry->name }}</td>
                    <td>{{ $inquiry->status }}</td>
                    <td>{{ $inquiry->created_at->format('Y/m/d H:i') }}</td>
                    <td>{{ $inquiry->email }}</td>
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
