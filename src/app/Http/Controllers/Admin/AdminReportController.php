<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report;

class AdminReportController extends Controller
{
    public function index()
    {
        $reports = Report::with(['reportedProduct', 'reportedUser', 'reporter'])->latest()->paginate(10);
        return view('admin.report_index', compact('reports'));
    }
}
