@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">お問い合わせ返信</h2>

    <form method="POST" action="{{ route('admin.inquiries.store', $inquiry->id) }}">
        @csrf
        @method('PUT')

        <div class="card mx-auto p-4" style="max-width: 700px;">
            {{-- 件名 --}}
            <div class="mb-3">
                <label>件名</label>
                <div class="form-control-plaintext">{{ $title }}</div>
            </div>

            {{-- 本文 --}}
            <div class="mb-3">
                <label>本文</label>
                <div class="form-control-plaintext">{{ $body }}</div>
            </div>

             {{-- 内容を保持 --}}
            <input type="hidden" name="reply" value="{{ $reply }}">

            {{-- ボタン --}}
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.inquiries.index') }}" class="btn btn-secondary">←戻る</a>
                <button type="submit" class="btn btn-primary">返信</button>
            </div>
        </div>
    </form>
</div>
@endsection