<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
        }
        p {
            white-space: pre-wrap;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>{{ $article->title }}</h1>
        <p>{!! nl2br(e($article->content)) !!}</p>
    </div>
</body>
</html>