@extends('layouts.app')

@section('head')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

 <style>


    .titlebox{
        max-width: 800px;
        margin: 50px auto;
        padding: 20px;
        background-color: #ffff;
        border: 5px solid #ddd;
        text-align: center;
       }

    .content{
       text-align: center;
    }

   .favorite-btn {
    font-size: 24px;
    border: none;
    background: none;
    cursor: pointer;
    transition: color 0.2s ease, transform 0.2s ease;
    }

   .favorite-btn.active {
    color: red; 
    }

    .favorite-btn.inactive {
    color: #ccc; 
    }

    .buttonbox{
    max-width: 370px;
    margin: 50px auto;
    padding: 20px;
        text-align: center;
    }

    .comment{
        text-align: center;
    }

 </style>
@endsection


@section('content')
<div class="container">

    {{-- フラッシュメッセージ --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

          {{-- タイトルとお気に入り --}}
      <div class="d-flex align-items-center justify-content-between align-items-center mb-3">
            <div class="mx-auto text-center titlebox">
                  <h2>{{ $article->title }}</h2>
            </div>

            
          {{-- お気に入りボタン --}}
      <div class="d-flex align-items-center gap-2">
          @if(auth()->guard('user')->check())
              @csrf
              <button type="button" class="favorite-btn {{ $isFavorited ? 'active' : 'inactive' }}" data-article-id="{{$article->id}}">
                   <i class="{{ $isFavorited ? 'fas fa-heart' : 'far fa-heart' }}"></i>
              </button>
              <span class="favorite-count">{{ $article->favorites_count }}</span>
          @endif


          {{-- いいね数表示 --}}
         @auth('instructor')
           {{-- 講師の場合は自分の記事だけ --}}
           @if($article->instructor_id === auth('instructor')->id())
            <div class="d-flex align-items-center">
              <i class="fas fa-heart text-danger me-1"></i>
              <p class="font-size: 50px;">{{ $article->favorites_count }}</p>
            </div>
           @endif
          @endauth

         @auth('admin')
        {{-- 管理者は全記事に表示 --}}
            <div class="d-flex align-items-center">
              <i class="fas fa-heart text-danger me-1"></i>
              <p class="font-size: 50px;">{{ $article->favorites_count }}</p>
            </div>
         @endauth

         <div class="mx-3"></div>
         
         @if(auth()->guard('user')->check())
         @php
         $reader = $article->readers->firstWhere('id', auth()->id());
         $completed = $reader ? $reader->pivot->completed : false;
         @endphp
         
         @if(!$completed)
         <form method="POST" action="{{ route('articles.complete', $article->id) }}">
            @csrf
            <button type="submit" class="btn btn-success">修了する</button>
          </form>
         @else
           <span class="text-success">✔ 修了済み</span>
         @endif
        @endif
      </div>
  </div>

    <br>

  <div class="mt-2">
    @if($article->faceType)
      <span class="badge bg-secondary-subtle">{{$article->faceType->name}}</span>
    @endif
    @if($article->personalColor)
      <span class="badge bg-secondary-subtle">{{ $article->personalColor->name }}</span>
    @endif
  </div>
    
    
          {{-- 本文・画像 --}}
          <div class ="content row mb-4">
                <div class="col mx-auto" style="max-width: 800px;">
                    <p class="text-start">{{ $article->content }}</p>
                </div>

                @if($article->image_path)
                 <div class="col-md-4">
                       <img src="{{ asset('storage/' . $article->image_path) }}" alt="記事画像" class="img-fluid">
                 </div>
                @endif

          </div>

          {{-- Youtube --}}
          @if($article->youtube_video_id)
             <iframe width="560" height="315"
                src="https://www.youtube.com/embed/{{ $article->youtube_video_id }}"
                frameborder="0" allowfullscreen>
              </iframe>
          @endif

          {{-- 投稿者プロフィール --}}
          <div class="mb-4 p-3 border rounded bg-light">
             <div class="d-flex align-item-center">
                  <img src="{{ optional($article->instructor)->image_path 
                            ? asset('storage/' . $article->instructor->image_path) 
                            : asset('images/default-profile.png') }}" 
                    alt="プロフィール画像" width="80">
                  <div class="ms-3">
                    <strong>{{ optional($article->instructor)->name }}</strong>(メイク講師)<br>
                    <a href="{{ route('instructor.profile.show',['profile' => optional($article->instructor)->profile->id]) }}">プロフィールを見る</a>
                  </div>
                </div>
            </div>

{{-- 操作ボタン --}}
<div class="buttonbox mb-4 d-flex gap-3 justify-content-center flex-wrap">

    {{-- 戻るボタン --}}
     @if(Auth::guard('admin')->check())
       <a href="{{ route('admin.top.index') }}" class="btn btn-secondary custom-btn">戻る</a>
      @elseif(Auth::guard('instructor')->check())
       <a href="{{ route('instructor.top.index') }}" class="btn btn-secondary custom-btn">戻る</a>
      @else
       <a href="{{ route('top.index') }}" class="btn btn-secondary custom-btn">戻る</a>
     @endif


    @if(auth()->guard('admin')->check())
        {{-- 管理者は戻るボタンのみ --}}

    @elseif(auth()->guard('instructor')->check() && $article->instructor_id === auth('instructor')->id())
        {{-- 編集ボタン --}}
        <a href="{{ route('instructor.articles.edit', $article->id) }}" class="btn btn-warning custom-btn">編集</a>

        {{-- 削除ボタン（form） --}}
        <form action="{{ route('instructor.articles.destroy', $article->id) }}" method="POST"
              onsubmit="return confirm('本当に削除しますか？');"
              style="margin: 0;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger custom-btn">削除</button>
        </form>

    @elseif(auth()->guard('user')->check())
        {{-- コメントボタン --}}
        <a href="{{ route('comments.create', ['article' => $article->id]) }}" class="btn btn-primary custom-btn">コメント</a>

        {{-- ダウンロードボタン --}}
        <a href="{{ route('articles.downloadPdf', $article->id) }}"
           class="btn btn-outline-dark custom-btn">ダウンロード</a>
    @endif

</div>


            {{-- コメント一覧 --}}
           <div class="comment mb-4">
                    <h4 class="mb-5">コメント一覧</h4>
            @forelse ($article->comments()->parentComment()->get() as $comment)
              <div class="border rounded p-3 mb-3 bg-light">
                <div class="d-flex justify-content-between align-items-start mb-2">
                 <div>
                    <strong>{{ $comment->nickname }}</strong>
                    @if ($comment->age) （{{ $comment->age }}歳）@endif
                    @if ($comment->gender) ・{{ $comment->gender == 'male' ? '男性' : ($comment->gender == 'female' ? '女性' : 'その他') }} @endif
                 </div>
                 <div class="text-muted" style="font-size: 0.9em;">
                    {{ $comment->created_at->format('Y/m/d H:i') }}
                 </div>

                 {{--コメント削除--}}
                  @php
                     $user = auth()->guard('user')->check() ? auth()->id() : null;
                     $instructor = auth()->guard('instructor')->check() ? auth('instructor')->id() : null;
                  @endphp

                  @if(($user && $comment->user_id === $user) || ($instructor && $comment->article->instructor_id === $instructor))
                 <form action="{{ $instructor ? route('instructor.comments.destroy', $comment->id) : route('comments.destroy', $comment->id)}}" method="POST" style="display:inline;" onsubmit="return confirm('本当に削除しますか？');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-link text-danger p-0" style="font-size: 0.9em;">
                        <i class="fas fa-trash-alt"></i>
                  </button>
                 </form>
                 @endif
                </div>

                  {{-- コメント内容 --}}
                  <p class="text-start">{{ $comment->content }}</p>

                  {{-- メイク講師の返信フォーム --}}
                  @auth('instructor') 
                  @if($article->instructor_id === auth('instructor')->id())
                  <div class="d-flex justify-content-end">
                      <a href="javascript:void(0);" onclick="toggleReplyForm({{ $comment->id }})" id="reply-toggle-{{ $comment->id }}">
                          返信する ▼
                        </a>
                  </div>
                </div>

                {{-- ▼ フォーム：初期状態は非表示 --}}
                <div id="reply-form-{{ $comment->id }}" style="display: none;" class="ms-4 mt-2">  
                    <form action="{{ route('instructor.comments.reply',$comment->id) }}" method="POST">
                        @csrf
                        <div class="mb-2">
                            <label for="content-{{ $comment->id }}">返信内容</label>
                            <textarea name="content" id="content-{{ $comment->id }}" class="form-control" rows="2" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary">返信する</button>
                    </form>
                </div>
                @endif
                @endauth

            {{-- 返信数リンク --}}
            @if ($comment->replies->count() > 0)
             <div class="text-start mt-2">
                <a href="javascript:void(0);" onclick="toggleReplies('{{$comment->id}}')" class="text-start">
                    🔽 返信{{ $comment->replies->count() }}件を表示
                </a>
             </div>
            @endif
            
            {{-- 返信表示部分 --}}
            <div id="replies-{{ $comment->id }}" style="display: none; margin-top: 10px;">
                @foreach ($comment->replies as $reply)
                <div class="ms-4 p-2 border-start">
                    <div class="d-flex justify-content-between align-items-start mb-1">
                        <div>
                            <strong>{{ $reply->nickname }}</strong>
                            @if ($reply->age)（{{ $reply->age }}歳）@endif
                                @if ($reply->gender) ・{{ $reply->gender == 'male' ? '男性' : ($reply->gender == 'female' ? '女性' : 'その他') }} @endif
                            </div>
                            <div class="text-muted" style="font-size: 0.85em;">
                                {{ $reply->created_at->format('Y/m/d H:i') }}
                            </div>
                        </div>
                        <p>{{ $reply->content }}</p>
                    </div>
                @endforeach
            </div>
            
</div>
    @empty
        <p>まだコメントがありません。</p>
    @endforelse
</div>



  {{-- JavaScript（返信表示の切り替え） --}}
      <script>
    function toggleReplies(commentId) {
    const repliesDiv = document.getElementById('replies-' + commentId);
    if (!repliesDiv) {
        console.error('Replies div not found for commentId:', commentId);
        return;
    }

    if (repliesDiv.style.display === 'none') {
        repliesDiv.style.display = 'block';
    } else {
        repliesDiv.style.display = 'none';
    }
}
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.favorite-btn').click(function() {
        const btn = $(this);
        const articleId = btn.data('article-id');

        $.ajax({
            url: '/favorites/toggle/' + articleId,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                // ハートアイコン切替
                if (btn.hasClass('active')) {
                    btn.removeClass('active').addClass('inactive');
                    btn.find('i').removeClass('fas').addClass('far');
                } else {
                    btn.removeClass('inactive').addClass('active');
                    btn.find('i').removeClass('far').addClass('fas');
                }

                // お気に入り数更新
                btn.siblings('.favorite-count').text(response.favorites_count);
            },
            error: function(err) {
                alert('お気に入りの更新に失敗しました');
            }
        });
    });
});
</script>



@endsection