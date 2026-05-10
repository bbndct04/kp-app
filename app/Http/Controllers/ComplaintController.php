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
            // Section 1 - Complainant
            'complainant_formal_name' => 'required|string|max:255',
            'complainant_contact'     => 'required|string|max:20',
            'complainant_address'     => 'required|string|max:500',

            // Section 2 - Respondent
            'respondent_name'         => 'required|string|max:255',
            'respondent_address'      => 'required|string|max:500',

            // Section 3 - Incident
            'category'                => 'required|string',
            'other_category'          => 'nullable|string|max:255|required_if:category,Other',
            'incident_date'           => 'required|date|before_or_equal:today',
            'incident_time'           => 'required',
            'location'                => 'required|string|max:500',
            'description'             => 'required|string|min:20',
            'relief_requested'        => 'required|string|min:5',
            'attachment'              => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240',
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
            'user_id'                 => auth()->id(),
            'reference_number'        => $refNo,
            'case_number'             => $caseNo,
            'category'                => $request->category === 'Other'
                                            ? $request->other_category
                                            : $request->category,
            'other_category'          => $request->other_category,
            'complainant_formal_name' => $request->complainant_formal_name,
            'complainant_contact'     => $request->complainant_contact,
            'complainant_address'     => $request->complainant_address,
            'respondent_name'         => $request->respondent_name,
            'respondent_address'      => $request->respondent_address,
            'description'             => $request->description,
            'incident_date'           => $request->incident_date,
            'incident_time'           => $request->incident_time,
            'location'                => $request->location,
            'relief_requested'        => $request->relief_requested,
            'attachment'              => $attachmentPath,
            'status'                  => 'pending',
        ]);

        // ✅ Redirect back to create page with correct session key
        // so the 24-hour popup modal triggers properly
        return redirect()->route('complaints.create')
            ->with('complaint_submitted', $refNo);
    }
}