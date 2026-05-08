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
    'description',
    'incident_date',
    'incident_time',
    'location',
    'persons_involved',
    'respondent_name',
    'respondent_address',
    'complainant_formal_name',
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