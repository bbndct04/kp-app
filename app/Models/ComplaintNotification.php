<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ComplaintNotification extends Model
{
    use HasFactory;

    protected $table = 'complaint_notifications';

    protected $fillable = [
        'user_id',
        'complaint_id',
        'title',
        'message',
        'type',
        'is_read',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }
}