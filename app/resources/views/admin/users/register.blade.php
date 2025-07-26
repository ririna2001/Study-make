@entends('layouts.admin')

@section('content')

{{-- 見出し --}}
<h2 class="text-center mb-4">管理者アカウント登録</h2>

{{-- 入力フォーム --}}
    <form method="POST" action="{{ route('admin.register.confirm') }}">
        @csrf

        <div class="card mx-auto p-4" style="max-width: 500px;">
            {{-- 名前 --}}
            <div class="mb-3">
                <label for="name">名前</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            {{-- メールアドレス --}}
            <div class="mb-3">
                <label for="email">メールアドレス</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>

            {{-- パスワード --}}
            <div class="mb-3">
                <label for="password">パスワード</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>

            {{-- パスワード確認 --}}
            <div class="mb-4">
                <label for="password_confirmation">パスワード（確認）</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
            </div>

            {{-- ボタン --}}
            <div class="d-flex justify-content-between">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">←戻る</a>
                <button type="submit" class="btn btn-primary">確認</button>
            </div>
        </div>
    </form>
</div>
@endsection

