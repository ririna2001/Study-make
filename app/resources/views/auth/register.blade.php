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

        .label-col {
        width: 150px;
        text-align: right;
        padding-right: 10px;
        white-space: nowrap;
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

       <div class="row mb-3 align-items-center">
          <div class="col-md-4 d-flex justify-content-end">
            <label class="form-label mb-0 label-col">■ 名前</label>
          </div>
          <div class="col-md-8">
            <input type="text" name="name" class="form-control" value="{{ old('name')}}">
          </div>
       </div>


  {{-- 年齢 --}}
    <div class="row mb-3 align-items-center">
        <div class="col-md-4 d-flex justify-content-end">
            <label class="form-label mb-0 label-col">■ 年齢（任意）</label>
        </div>
        <div class="col-md-8">
            <select name="age" class="form-select">
                <option value="">選択してください</option>
                @for ($i = 10; $i <= 100; $i++)
                    <option value="{{ $i }}" {{ old('age') == $i ? 'selected' : '' }}>{{ $i }}歳</option>
                @endfor
            </select>
        </div>
    </div>

    {{-- 性別 --}}
    <div class="row mb-3 align-items-center">
        <div class="col-md-4 d-flex justify-content-end">
           <label class="form-label mb-0 label-col">■ 性別（任意）</label>
        </div>
        <div class="col-md-8">
            <div class="form-check form-check-inline">
                <input type="radio" name="gender" value="男性" class="form-check-input" {{ old('gender') == '男性' ? 'checked' : '' }}>
                <label class="form-check-label">男性</label>
            </div>
            <div class="form-check form-check-inline">
                <input type="radio" name="gender" value="女性" class="form-check-input" {{ old('gender') == '女性' ? 'checked' : '' }}>
                <label class="form-check-label">女性</label>
            </div>
        </div>
    </div>

    {{-- 職業 --}}
    <div class="row mb-3 align-items-center">
        <div class="col-md-4 d-flex justify-content-end">
           <label class="form-label mb-0 label-col">■ 職業（任意）</label>
        </div>
        <div class="col-md-8">
            <select name="occupation" class="form-select">
                <option value="">選択してください</option>
                <option value="会社員" {{ old('occupation') == '会社員' ? 'selected' : ''}}>会社員</option>
                <option value="学生" {{ old('occupation') == '学生' ? 'selected' : '' }}>学生</option>
            </select>
        </div>
    </div>

    {{-- メールアドレス --}}
    <div class="row mb-3 align-items-center">
        <div class="col-md-4 d-flex justify-content-end">
           <label class="form-label mb-0 label-col">■ メールアドレス（必須）</label>
        </div>
        <div class="col-md-8">
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>
    </div>

    {{-- パスワード --}}
   <div class="row mb-3 align-items-center">
            <div class="col-md-4 d-flex justify-content-end">
                <label class="form-label mb-0 label-col">■ パスワード（必須）</label>
            </div>
            <div class="col-md-8">
                <input type="password" name="password" class="form-control" required>
            </div>
    </div>

    {{-- パスワード（確認） --}}
   <div class="row mb-3 align-items-center">
            <div class="col-md-4 d-flex justify-content-end">
                <label class="form-label mb-0 label-col">■ パスワード（確認）</label>
            </div>
            <div class="col-md-8">
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
    </div>

    {{-- 顔タイプ --}}   
      <div class="row mb-3 align-items-center">
            <div class="col-md-4 d-flex justify-content-end">
                <label class="form-label mb-0 label-col">■ 顔タイプ（任意）</label>
            </div>
            <div class="col-md-8">
                <select name="face_type" class="form-select">
                    <option value="">選択してください</option>
                    <option value="キュート" {{ old('face_type') == 'キュート' ? 'selected' : '' }}>キュート</option>
                    <option value="フレッシュ" {{ old('face_type') == 'フレッシュ' ? 'selected' : '' }}>フレッシュ</option>
                    <option value="アクティブキュート" {{ old('face_type') == 'アクティブキュート' ? 'selected' : '' }}>アクティブキュート</option>
                    <option value="クールカジュアル" {{ old('face_type') == 'クールカジュアル' ? 'selected' : '' }}>クールカジュアル</option>
                    <option value="フェミニン" {{ old('face_type') == 'フェミニン' ? 'selected' : '' }}>フェミニン</option>
                    <option value="ソフトエレガント" {{ old('face_type') == 'ソフトエレガント' ? 'selected' : '' }}>ソフトエレガント</option>
                    <option value="エレガント" {{ old('face_type') == 'エレガント' ? 'selected' : '' }}>エレガント</option>
                    <option value="クール" {{ old('face_type') == 'クール' ? 'selected' : '' }}>クール</option>
                </select>
            </div>
        </div>

    {{-- パーソナルカラー --}}
    <div class="row mb-3 align-items-center">
            <div class="col-md-4 d-flex justify-content-end">
                <label class="form-label mb-0 label-col">■ パーソナルカラー（任意）</label>
            </div>
            <div class="col-md-8">
                <select name="personal_color" class="form-select">
                    <option value="">選択してください</option>
                    <option value="イエベ春" {{ old('personal_color') == 'イエベ春' ? 'selected' : '' }}>イエベ春</option>
                    <option value="ブルべ夏" {{ old('personal_color') == 'ブルべ夏' ? 'selected' : '' }}>ブルべ夏</option>
                    <option value="イエベ秋" {{ old('personal_color') == 'イエベ秋' ? 'selected' : '' }}>イエベ秋</option>
                    <option value="ブルべ冬" {{ old('personal_color') == 'ブルべ冬' ? 'selected' : '' }}>ブルべ冬</option>
                </select>
            </div>
        </div>

    {{-- ご利用方法 --}}
    <div class="row mb-4 align-items-center">
            <div class="col-md-4 d-flex justify-content-end">
                <label class="form-label mb-0 label-col">■ ご利用方法</label>
            </div>
            <div class="col-md-8">
                <select name="role" class="form-select">
                    <option value="">選択してください</option>
                    <option value="一般" {{ old('role') == '一般' ? 'selected' : '' }}>一般</option>
                    <option value="メイク講師" {{ old('role') == 'メイク講師' ? 'selected' : '' }}>メイク講師</option>
                </select>
            </div>
    </div>

        <button type="submit" class="btn btn-primary">確認</button>     
    </form>
</div>
</body>
</html>
