<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
    'user_id',
    'reference_number',
    'case_number',
    'case_level',
    'category',
    'other_category',        // ← NEW
    'description',
    'incident_date',
    'incident_time',
    'location',
    'complainant_formal_name',
    'complainant_contact',   // ← NEW
    'complainant_address',   // ← NEW
    'respondent_name',
    'respondent_address',
    'relief_requested',
    'attachment',
    'status',
    'remarks',
    'hearing_date',
    'hearing_time',
    'punong_barangay',
    'pangkat_chairman',
    'mediation_notes',
    'mediation_outcome',
    'settlement_details',
    'escalation_reason',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}