@extends('layout.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/report_index.css') }}">
@endsection

@section('content')
    <div class="admin_report">

        <h2>通報一覧</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>商品</th>
                    <th>通報者</th>
                    <th>対象ユーザー</th>
                    <th>理由</th>
                    <th>詳細コメント</th>
                    <th>日付</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reports as $report)
                <tr>
                    <td>{{ $report->id }}</td>
                    <td>
                        @if ($report->reportedProduct)
                            <a href="{{ route('products-show', $report->reportedProduct->id) }}">
                                {{ $report->reportedProduct->name }}
                            </a>
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $report->reporter->name ?? '不明' }}</td>
                    <td>{{ $report->reportedUser->name ?? '不明' }}</td>
                    <td>{{ $report->reason }}</td>
                    <td>{{ $report->comment ?? 'なし' }}</td>
                    <td>{{ $report->created_at->format('Y-m-d H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $reports->links() }}
    </div>

    @if(session('success'))
        <div class="alert alert_success">
            <p class="success_message">{{ session('success') }}</p>
        </div>
    @endif
@endsection
