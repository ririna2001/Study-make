@extends('layouts.app')

@section('content')
<div class="container">
  <h2>お知らせ一覧</h2>

  {{-- 新着メッセージ --}}
  @if (count($notifications) > 0)
      <p>新着{{ count($notifications) }}件のお知らせが来ています！</p>
  @elseif
      <p>現在新着のお知らせはありません</p> 
  @endif

  {{-- お知らせ一覧 --}}
  <ul class="list-group">
      @foreach($notifications as $notification)
        <li class="list-group-item d-flex justify-content-between align-item-center">
              <div>
                <small>{{ $notification->created_at->format('y/m/d') }}</small>
                <strong>{{ $notification->title }}</strong>
              </div>
              <a href="{{ route('notifications.show', $notification->id) }}" class="btn btn-outline-primary">▶</a>
        </li>
      @endforeach
  </ul>

  <br>
  
  @php
    $role = Auth::user()->role;
  @endphp

 @switch(Auth::user()->role)
    @case('user')
        <a href="{{ route('mypage.user') }}" class="btn btn-secondary">← 戻る</a>
        @break

    @case('instructor')
        <a href="{{ route('mypage.instructor') }}" class="btn btn-secondary">← 戻る</a>
        @break

    @case('admin')
        <a href="{{ route('mypage.admin') }}" class="btn btn-secondary">← 戻る</a>
        @break

    @default
        <a href="{{ route('home') }}" class="btn btn-secondary">← ホームへ戻る</a>
@endswitch

</div>
@endsection