<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>通報通知</title>
</head>
<body>
    <h1>新しい通報がありました</h1>

    <p><strong>通報理由：</strong> {{ $report->reason }}</p>
    <p><strong>詳細コメント：</strong> {{ $report->comment ?? 'なし' }}</p>

    @if($report->reportedProduct)
        <p><strong>対象商品：</strong> <a href="{{ url('/products/' . $report->reportedProduct->id) }}">{{ $report->reportedProduct->name }}</a></p>
    @endif

    <p><strong>通報者：</strong> {{ $report->reporter->name ?? '不明' }}</p>
    <p><strong>対象ユーザー：</strong> {{ $report->reportedUser->name ?? '不明' }}</p>

    <p>詳細は管理者ページで確認してください。</p>

    <p><a href="{{ url('/admin/reports') }}">通報一覧を見る</a></p>
</body>
</html>
