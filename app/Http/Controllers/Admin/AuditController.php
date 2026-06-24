<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GradingRequest;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    public function index()
    {
        $requests = GradingRequest::with(['pokemonCard', 'customer', 'grader', 'package'])
            ->whereNotNull('grader_id')
            ->latest()
            ->get();

        return view('admin.grading_audit', compact('requests'));
    }
}