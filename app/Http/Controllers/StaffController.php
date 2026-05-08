<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class StaffController extends Controller
{
    // Complaint Detail Page
    public function show(Complaint $complaint)
    {
        return view('staff.complaint-detail', compact('complaint'));
    }

    // Encode Respondent Details + Submit for Review
    public function validate(Request $request, Complaint $complaint)
    {
        $request->validate([
            'respondent_name'        => 'required|string|max:255',
            'respondent_address'     => 'required|string|max:500',
            'relief_requested'       => 'nullable|string',
            'complainant_formal_name'=> 'nullable|string|max:255',
        ]);

        $complaint->update([
            'respondent_name'         => $request->respondent_name,
            'respondent_address'      => $request->respondent_address,
            'relief_requested'        => $request->relief_requested,
            'complainant_formal_name' => $request->complainant_formal_name ?? $complaint->user->name,
            'status'                  => 'for_review',
        ]);

        return back()->with('success', 'Complaint details encoded and submitted for admin review.');
    }

    // Record Mediation
    public function mediation(Request $request, Complaint $complaint)
    {
        $request->validate([
            'mediation_notes'   => 'required|string',
            'mediation_outcome' => 'required|in:settled,not_settled,escalated',
            'settlement_details'=> 'nullable|string',
            'escalation_reason' => 'nullable|string',
            'punong_barangay'   => 'nullable|string',
            'pangkat_chairman'  => 'nullable|string',
        ]);

        $status = match($request->mediation_outcome) {
            'settled'     => 'resolved',
            'not_settled' => 'ongoing',
            'escalated'   => 'escalated',
        };

        $complaint->update([
            'mediation_notes'    => $request->mediation_notes,
            'mediation_outcome'  => $request->mediation_outcome,
            'settlement_details' => $request->settlement_details,
            'escalation_reason'  => $request->escalation_reason,
            'punong_barangay'    => $request->punong_barangay,
            'pangkat_chairman'   => $request->pangkat_chairman,
            'status'             => $status,
        ]);

        return back()->with('success', 'Mediation details recorded successfully.');
    }

    // Close Case
    public function close(Complaint $complaint)
    {
        $complaint->update(['status' => 'closed']);
        return back()->with('success', 'Case has been closed and archived.');
    }

    // Generate KP Form PDF
    public function generateForm(Complaint $complaint, $formNumber)
    {
        $barangay = [
            'name'     => 'Barangay New Kababae',
            'city'     => 'Olongapo City',
            'province' => 'Zambales',
        ];

        $view = match($formNumber) {
            '7'  => 'staff.forms.form7',
            '8'  => 'staff.forms.form8',
            '9'  => 'staff.forms.form9',
            '16' => 'staff.forms.form16',
            default => abort(404),
        };

        $pdf = Pdf::loadView($view, compact('complaint', 'barangay'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('KP-Form-'.$formNumber.'-'.$complaint->case_number.'.pdf');
    }
}