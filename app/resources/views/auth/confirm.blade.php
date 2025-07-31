@extends('layouts')

@section('content')
<div class="container">
    <h2>登録内容の確認</h2>

    <form method="POST" action="{{ route('register.complete') }}">
        @csrf

        <dl>
            <dt>名前</dt>
            <dd>{{ $input['name']}}</dd>

            <dt>年齢</dt>
            <dd>{{ $input['age'] ?? '未入力' }}</dd>

            <dt>性別</dt>
            <dd>{{ $input['gender'] ?? '未入力' }}</dd>

            <dt>職業</dt>
            <dd>{{ $input['occupation'] ?? '未入力' }}</dd>

            <dt>メールアドレス</dt>
            <dd>{{ $input['email'] }}</dd>

            <dt>顔タイプ</dt>
            <dd>{{ $input['face_type'] ?? '未入力' }}</dd>

            <dt>パーソナルカラー</dt>
            <dd>{{ $input['personal_color'] ?? '未入力' }}</dd>
        </dl>

        {{--データを保持 --}}
        @foreach ($input as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach

        <button type="submit" class="btn btn-primary">登録する</button>
    </form>

    <form method="POST" action="{{ route('register.back') }}" class="mt-3">
        @csrf
        @foreach ($input as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
        <button type="submit" class="btn btn-secondary">戻る</button>
    </form>
</div>
@endsection