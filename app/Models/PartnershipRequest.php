<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnershipRequest extends Model
{
    protected $fillable = [
        'organization_name',
        'contact_person',
        'email',
        'phone',
        'request_type',
        'description',
        'privacy_accepted',
        'status',
        'admin_notes',
        'ip_address',
    ];

    protected function casts(): array
    {
        return [
            'privacy_accepted' => 'boolean',
        ];
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'قيد المراجعة',
            'reviewed' => 'تمت المراجعة',
            'contacted' => 'تم التواصل',
            'rejected' => 'مرفوض',
            default => $this->status,
        };
    }
}
