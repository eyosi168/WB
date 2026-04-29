<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Bureau;
use App\Models\Report;
use App\Models\ReportTracker;
use App\Models\ReportAttachment;

class PublicReportController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        // We fetch all bureaus so the JavaScript can filter them without page refreshes
        $bureaus = Bureau::all();

        return view('reports.create', [
            'categories' => $categories,
            'bureaus' => $bureaus
        ]);
    }

    public function store(Request $request)
    {
        // 1. Validate the incoming data
        $validated = $request->validate([
            'bureau_id' => 'required|exists:bureaus,id',
            'category_id' => 'required|exists:categories,id',
            'address' => 'nullable|string|max:255',
            'description' => 'required|string',
            'passcode' => 'required|digits:6',
            'evidence.*' => 'nullable|file|max:10240',
        ]);

        try {
            DB::beginTransaction();

            // Create the main Report
            $report = Report::create([
                'bureau_id' => $validated['bureau_id'],
                'category_id' => $validated['category_id'],
                'address' => $validated['address'],
                'description' => $validated['description'],
                'status' => 'pending',
                'priority' => 'normal',
            ]);

            // 3. Generate Tracking ID
            $trackingId = 'WB-' . strtoupper(Str::random(6)); 
            
            ReportTracker::create([
                'report_id' => $report->id,
                'tracking_id' => $trackingId,
                'passcode' => $validated['passcode'], 
            ]);

            // 4. Handle Uploads
            if ($request->hasFile('evidence')) {
                foreach ($request->file('evidence') as $file) {
                    $path = $file->store('attachments', 's3');
                    
                    ReportAttachment::create([
                        'report_id' => $report->id,
                        'file_path' => $path,
                        'file_name' => $file->getClientOriginalName(),
                        'mime_type' => $file->getMimeType(),
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('report.success')->with('tracking_id', $trackingId);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong. Please try again.')->withInput();
        }
    }

    public function success()
    {
        if (!session('tracking_id')) {
            return redirect()->route('report.create');
        }
        return view('reports.success');
    }
}