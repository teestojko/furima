<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'reported_product_id' => 'nullable|exists:products,id',
        'reported_user_id' => 'nullable|exists:users,id',
        'reason' => 'required|string|max:255',
    ]);

    Report::create([
        'reported_product_id' => $request->reported_product_id,
        'reported_user_id' => $request->reported_user_id,
        'reporter_user_id' => auth()->id(),
        'reason' => $request->reason,
    ]);

    return back()->with('success', '通報が送信されました。');
}

}
