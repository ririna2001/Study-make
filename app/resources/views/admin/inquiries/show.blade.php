@extends('layouts.admin')

@section('content')

<div class="container">
  <h2>お問い合わせ内容</h2>

     {{-- 対応状況表示 --}}
    <div class="mb-4">
        <span class="px-3 py-1 rounded border border-gray-500 bg-gray-100">
            {{ $inquiry->status }}
        </span>
    </div>

    {{-- 詳細内容表示 --}}
    <div class="mb-4">
        <label>お問い合わせID</label>
        <input type="text" value="{{ $inquiry->id }}" class="form-input w-full" readonly>
    </div>

    <div class="mb-4">
        <label>お名前</label>
        <input type="text" value="{{ $inquiry->name }}" class="form-input w-full" readonly>
    </div>

    <div class="mb-4">
        <label>メールアドレス</label>
        <input type="text" value="{{ $inquiry->email }}" class="form-input w-full" readonly>
    </div>

    <div class="mb-4">
        <label>お問い合わせ項目</label>
        <input type="text" value="{{ $inquiry->category }}" class="form-input w-full" readonly>
    </div>

    <div class="mb-4">
        <label>お問い合わせ内容</label>
        <textarea class="form-textarea w-full" rows="6" readonly>{{ $inquiry->content }}</textarea>
    </div>

    {{-- 戻る・返信ボタン --}}
    <div class="flex justify-between mt-6">
        <a href="{{ route('admin.inquiries.index') }}" class="btn btn-secondary">←戻る</a>

        <form action="{{ route('admin.inquiries.reply', $inquiry->id) }}" method="get">
            <button type="submit" class="btn btn-primary">返信</button>
        </form>
    </div>
</div>
@endsection













</div>