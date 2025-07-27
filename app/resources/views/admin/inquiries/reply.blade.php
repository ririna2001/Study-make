@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">お問い合わせ返信</h2>

    <form method="POST" action="{{ route('admin.inquiries.confirm', $inquiry->id) }}">
        @csrf
        @method('PUT')

        <div class="card mx-auto p-4" style="max-width: 700px;">
            {{-- 件名 --}}
            <div class="mb-3">
                <label for="title">件名</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ $inquiry->title }}" readonly>
            </div>

            {{-- 本文 --}}
            <div class="mb-3">
                <label for="body">本文</label>
                <textarea id="body" name="body" class="form-control" rows="6" readonly>{{ $inquiry->body }}</textarea>
            </div>

            {{-- ボタン --}}
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.inquiries.index') }}" class="btn btn-secondary">← 戻る</a>
                <button type="submit" class="btn btn-primary">返信</button>
            </div>
        </div>
    </form>
</div>
@endsection