<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FURIMA</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/report_index.css') }}">
</head>
<body>
    <div class="page admin_report_page">
        <div class="page_inner admin_report_inner">
            <h2 class="page_section admin_report_title">通報一覧</h2>
            <div class="page_section admin_report_table_wrapper">
                <table class="admin_report_table">
                    <thead>
                        <tr class="admin_report_table_head_row">
                            <th class="table_title">ID</th>
                            <th class="table_title">商品</th>
                            <th class="table_title">通報者</th>
                            <th class="table_title">対象ユーザー</th>
                            <th class="table_title">理由</th>
                            <th class="table_title">詳細コメント</th>
                            <th class="table_title">日付</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reports as $report)
                        <tr class="admin_report_table_row">
                            <td class="admin_report_item">{{ $report->id }}</td>
                            <td class="admin_report_item">
                                @if ($report->reportedProduct)
                                    <a href="{{ route('products-show', $report->reportedProduct->id) }}" class="admin_report_product_link">
                                        {{ $report->reportedProduct->name }}
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="admin_report_item">{{ $report->reporter->name ?? '不明' }}</td>
                            <td class="admin_report_item">{{ $report->reportedUser->name ?? '不明' }}</td>
                            <td class="admin_report_item">{{ $report->reason }}</td>
                            <td class="admin_report_item">{{ $report->comment ?? 'なし' }}</td>
                            <td class="admin_report_item">{{ $report->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="admin_report_pagination">
                    {{ $reports->links() }}
                </div>
            </div>
            <div class="page_item admin_dashboard_back">
                <a class="admin_dashboard_back_link" href="{{ route('admin.dashboard') }}">
                    戻る
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert_success page_item admin_report_alert">
                    <p class="success_message">{{ session('success') }}</p>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
