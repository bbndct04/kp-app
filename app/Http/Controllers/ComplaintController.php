<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    public function create()
    {
        return view('complaints.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category'      => 'required|string',
            'description'   => 'required|string|min:20',
            'incident_date' => 'required|date',
            'incident_time' => 'required',
            'location'      => 'required|string',
        ]);

        // Generate reference number
        $year  = date('Y');
        $count = Complaint::whereYear('created_at', $year)->count() + 1;
        $refNo = 'BL-' . $year . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);

        // Generate case number
        $caseNo = 'CASE-' . date('mdy') . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);

        // Handle file upload
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')
                ->store('complaints', 'public');
        }

        Complaint::create([
            'user_id'          => auth()->id(),
            'reference_number' => $refNo,
            'case_number'      => $caseNo,
            'category'         => $request->category,
            'description'      => $request->description,
            'incident_date'    => $request->incident_date,
            'incident_time'    => $request->incident_time,
            'location'         => $request->location,
            'persons_involved' => $request->persons_involved,
            'attachment'       => $attachmentPath,
            'status'           => 'pending',
            'complainant_formal_name' => auth()->user()->name,
        ]);

        return redirect()->route('my-reports')
            ->with('success', 'Complaint submitted! Reference: ' . $refNo);
    }
}