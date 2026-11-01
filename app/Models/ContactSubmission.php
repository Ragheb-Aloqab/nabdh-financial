<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSubmission extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'status',
        'admin_notes',
        'ip_address',
    ];

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'unread' => 'جديد غير مقروء',
            'read' => 'تم الاطلاع',
            'replied' => 'تم الرد',
            'archived' => 'مؤرشف',
            default => $this->status,
        };
    }
}
