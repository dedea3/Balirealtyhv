<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'villa_id',
        'name',
        'email',
        'phone',
        'whatsapp',
        'check_in',
        'check_out',
        'number_of_guests',
        'number_of_rooms',
        'message',
        'special_requests',
        'status',
        'admin_notes',
        'assigned_to',
        'contacted_at',
        'confirmed_at',
        'source',
        'ip_address',
    ];

    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
        'contacted_at' => 'datetime',
        'confirmed_at' => 'datetime',
    ];

    public function villa(): BelongsTo
    {
        return $this->belongsTo(Villa::class);
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    public function scopeContacted($query)
    {
        return $query->where('status', 'contacted');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeArchived($query)
    {
        return $query->where('status', 'archived');
    }

    public function scopeForVilla($query, $villaId)
    {
        return $query->where('villa_id', $villaId);
    }

    public function isNew(): bool
    {
        return $this->status === 'new';
    }

    public function markAsContacted(): void
    {
        $this->update([
            'status' => 'contacted',
            'contacted_at' => now(),
        ]);
    }

    public function markAsConfirmed(): void
    {
        $this->update([
            'status' => 'confirmed',
            'confirmed_at' => now(),
        ]);
    }
}
