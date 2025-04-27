<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReportNotification;
use App\Models\Report;
use App\Models\Product;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{

    public function create(Request $request)
    {
        $reportedProduct = Product::findOrFail($request->reported_product_id);
        $reportedUser = $reportedProduct->user;

        return view('report.create', compact('reportedProduct', 'reportedUser'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'reported_product_id' => 'nullable|exists:products,id',
            'reported_user_id' => 'nullable|exists:users,id',
            'reason' => 'required|string|max:255',
            'comment' => 'nullable|string',
        ]);

        $report = Report::create([
            'reported_product_id' => $request->reported_product_id,
            'reported_user_id' => $request->reported_user_id,
            'reporter_user_id' => Auth::id(),
            'reason' => $request->reason,
            'comment' => $request->comment,
        ]);

    $adminEmails = Admin::pluck('email')->toArray();

    Mail::to($adminEmails)->send(new ReportNotification($report));

        return back()->with('success', '通報が送信されました。');
    }
}

