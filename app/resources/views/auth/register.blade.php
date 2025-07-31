<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>新規登録</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        .container-box{
          max-width: 1200px;
          margin: 50px auto;
          padding: 20px;
          background-color: #f9f9f9;
          border: 1px solid #ddd;
          text-align: center;
        }

       .container{
          max-width: 950px;
          margin: 50px auto;
          padding: 20px;
          background-color: #f9f9f9;
          border: 1px solid #ddd;
          text-align: center;
       }

    </style>
</head>

<body>
 <div class="container-box">
  <div class="container">
    <h2 style="text-align: center;">新規登録</h2>
  </div>

    {{-- エラーメッセージ --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container">
     <form method="POST" action="{{ route('register.confirm') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">名前</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
        </div>

        <div class="mb-3">
            <label for="age" class="form-label">年齢（任意）</label>
            <select name="age" class="form-select">
                <option value="">選択してください</option>
                @for ($i = 10; $i <= 100; $i++)
                    <option value="{{ $i }}" {{ old('age') == $i ? 'selected' : '' }}>{{ $i }}歳</option>
                @endfor
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">性別（任意）</label><br>
            <div class="form-check form-check-inline">
                <input type="radio" name="gender" value="男性" class="form-check-input" {{ old('gender') == '男性' ? 'checked' : '' }}>
                <label class="form-check-label">男性</label>
            </div>
            <div class="form-check form-check-inline">
                <input type="radio" name="gender" value="女性" class="form-check-input" {{ old('gender') == '女性' ? 'checked' : '' }}>
                <label class="form-check-label">女性</label>
            </div>
        </div>

        <div class="mb-3">
            <label for="occupation" class="form-label">職業（任意）</label>
            <select name="occupation" class="form-select">
                <option value="">選択してください</option>
                <option value="一般" {{ old('occupation') == '一般' ? 'selected' : '' }}>一般</option>
                <option value="メイク講師" {{ old('occupation') == 'メイク講師' ? 'selected' : '' }}>メイク講師</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">メールアドレス</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">パスワード</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">パスワード（確認）</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="face_type" class="form-label">顔タイプ（任意）</label>
            <select name="face_type" class="form-select">
                <option value="">選択してください</option>
                <option value="キュート" {{ old('face_type') == 'キュート' ? 'selected' : '' }}>キュート</option>
                <option value="アクティブキュート" {{ old('face_type') == 'アクティブキュート' ? 'selected' : '' }}>アクティブキュート</option>
                <option value="フレッシュ" {{ old('face_type') == 'フレッシュ' ? 'selected' : '' }}>フレッシュ</option>
                <option value="クールカジュアル" {{ old('face_type') == 'クールカジュアル' ? 'selected' : '' }}>クールカジュアル</option>
                <option value="フェミニン" {{ old('face_type') == 'フェミニン' ? 'selected' : '' }}>フェミニン</option>
                <option value="ソフトエレガント" {{ old('face_type') == 'ソフトエレガント' ? 'selected' : '' }}>ソフトエレガント</option>
                <option value="エレガント" {{ old('face_type') == 'エレガント' ? 'selected' : '' }}>エレガント</option>
                <option value="クール" {{ old('face_type') == 'クール' ? 'selected' : '' }}>クール</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="personal_color" class="form-label">パーソナルカラー（任意）</label>
            <select name="personal_color" class="form-select">
                <option value="">選択してください</option>
                <option value="イエベ春" {{ old('personal_color') == 'イエベ春' ? 'selected' : '' }}>イエベ春</option>
                <option value="ブルべ夏" {{ old('personal_color') == 'ブルべ夏' ? 'selected' : '' }}>ブルべ夏</option>
                <option value="イエベ秋" {{ old('personal_color') == 'イエベ秋' ? 'selected' : '' }}>イエベ秋</option>
                <option value="ブルべ冬" {{ old('personal_color') == 'ブルべ冬' ? 'selected' : '' }}>ブルべ冬</option>
            </select>
        </div>
    </div>

    <div class="mb-3">
            <label for="role" class="form-label">ご利用方法</label>
            <select name="role" class="form-select">
                <option value="">選択してください</option>
                <option value="一般" {{ old('role') == '一般' ? 'selected' : '' }}>一般</option>
                <option value="メイク講師" {{ old('role') == 'メイク講師' ? 'selected' : '' }}>メイク講師</option>
            </select>
    </div>


        <button type="submit" class="btn btn-primary">確認</button>     
    </form>
</div>
</body>
</html>
