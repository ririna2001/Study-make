@extends('layouts.app')

@section('content')
<div class="container mt-4">

          {{-- タイトルとお気に入り --}}
          <div class="d-flex justify-content-between align-items-center mb-3">
                  <h2>{{ $article->title }}</h2>

          {{-- お気に入りボタン --}}
            <form method="POST" action="{{ route('favorites.toggle', $article->id) }}">
              @csrf
              <button type="submit" class="btn btn-link p-0" style="font-size:10px;">
                 {!! $isFavorited ? '♥' : '♡' !!}
              </button>
            </form>
          </div>

          {{-- 本文・画像 --}}
          <div class ="row mb-4">
                <div class="col-md-8">
                    <p>{{ $article->body }}</p>
                </div>
                <div class="col-md-4">
                    @if($article->image_path)
                       <img src="{{ asset('storage/' . $article->image_path) }}" alt="記事画像" class="img-fluid">
                    @endif
                </div>
          </div>

          {{-- 投稿者プロフィール --}}
          <div class="mb-4 p-3 border rounded bg-light">
             <div class="d-flex align-item-center">
                  @if($article->user->profile_image)
                    <img src="{{ asset('storage/' . $article->user->profile_image) }}" alt="プロフィール画像" width="60">
                  @else
                    <div style="font-size: 30px;"></div>
                  @endif
                  <div class="ms-3">
                    <strong>{{ $article->user->name }}</strong>(メイク講師)<br>
                    <a href="{{ route('profiles.show',$article->user->id) }}">プロフィールを見る</a>
                  </div>
                </div>
            </div>

            {{-- 操作ボタン --}}
            <div class="mb-4 d-flex gap-3">
                  <a href="{{ route('articles.index') }}" class="btn btn-secondary"><-戻る</a>
                  <a href="#comment-form" class="btn btn-primary">コメント</a>
                  <a href="{{ route('articles.download', $article->id) }}"
                     class="btn btn-outline-dark" target="_blank" download>ダウンロード</a>
            </div>

            {{-- コメント一覧 --}}
           <div class="mb-4">
                    <h4>コメント一覧</h4>
            @forelse ($article->comments as $comment)
              <div class="border rounded p-3 mb-3 bg-light">
               <strong>{{ $comment->nickname }}</strong>
               @if ($comment->age)
                   （{{ $comment->age }}歳）
                @endif
                @if ($comment->gender)
                    ・{{ $comment->gender == 'male' ? '男性' : ($comment->gender == 'female' ? '女性' : 'その他') }}
                @endif
                 <br>
                 <p>{{ $comment->content }}</p>


           {{-- 返信数リンク（クリックで返信表示） --}}
            @if ($comment->replies->count() > 0)
              <a href="javascript:void(0);" onclick="toggleReplies('{{$comment->id}}')">
                🔽 返信{{ $comment->replies->count() }}件を表示
              </a>
           @else
             <span class="text-muted"></span>
           @endif


        {{-- 返信表示部分（初期は非表示） --}}
            <div id="replies-{{ $comment->id }}" style="display: none; margin-top: 10px;">
               @foreach ($comment->replies as $reply)
                <div class="ms-4 p-2 border-start">
                    <strong>{{ $reply->nickname }}</strong>
                    @if ($reply->age)（{{ $reply->age }}歳）@endif
                    @if ($reply->gender)
                        ・{{ $reply->gender == 'male' ? '男性' : ($reply->gender == 'female' ? '女性' : 'その他') }}
                    @endif
                    <p>{{ $reply->content }}</p>
                </div>
               @endforeach
           </div>

        {{-- メイク講師の返信フォーム --}}
        @auth
            @if(Auth::user()->role === 'メイク講師')
            <form action="{{ route('comments.reply',$comment->id) }}" method="POST" class="mt-2 ms-4">
              @csrf
            <div class="mb-2">
                <label for="content-{{ $comment->id }}">返信内容</label>
                <textarea name="content" id="content-{{ $comment->id }}" class="form-control" rows="2" required></textarea>
            </div>
            <button type="submit" class="btn btn-sm btn-primary">返信する</button>
        </form>
        @endif
    @endauth
</div>
  @empty
    <p>まだコメントがありません。</p>
  @endforelse

        {{-- JavaScript（返信表示の切り替え） --}}
        <script>
           function toggleReplies(commentId) {
              const repliesDiv = document.getElementById('replies-' + commentId);
              repliesDiv.style.display = (repliesDiv.style.display === 'none') ? 'block' : 'none';
            }
        </script>
@endsection