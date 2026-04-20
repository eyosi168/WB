<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReportTracker;
use App\Models\Report;
use Illuminate\Support\Facades\Hash;

class StatusController extends Controller
{
    // 1. Show the login form
    public function index()
    {
        return view('status.login');
    }

    // 2. Process the login
    public function authenticate(Request $request)
    {
        $request->validate([
            'tracking_id' => 'required|string',
            'passcode' => 'required|digits:6',
        ]);

        // Find the tracker by ID first
        $tracker = ReportTracker::where('tracking_id', $request->tracking_id)->first();

        // Check if tracker exists AND the hashed passcode matches
        if ($tracker && Hash::check($request->passcode, $tracker->passcode)) {
            // Save the report ID securely in the user's session
            session(['secure_report_id' => $tracker->report_id]);
            return redirect()->route('report.status.show');
        }

        // Failed login
        return back()->with('error', 'Invalid Tracking ID or Passcode.');
    }

    // 3. Show the actual report details
    public function show()
    {
        // Make sure they are logged in
        if (!session()->has('secure_report_id')) {
            return redirect()->route('report.status.index');
        }

        // Fetch the report with its relationships
        $report = Report::with(['bureau', 'category', 'attachments'])
            ->findOrFail(session('secure_report_id'));

        return view('status.show', compact('report'));
    }

    // 4. Secure Logout
    public function logout()
    {
        session()->forget('secure_report_id');
        return redirect()->route('report.status.index');
    }
}