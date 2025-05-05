<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\SeatStatus;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['label', 'event_id', 'is_reserved', 'is_sold'];

    protected $casts = [
        'status' => SeatStatus::class,
    ];

    public function isAvailable()
    {
        return (bool) !$this->is_reserved && !$this->is_sold;
    }

    public function isReserved()
    {
        return (bool) $this->is_reserved && !$this->is_sold;
    }

    public function isSold()
    {
        return (bool)$this->is_sold;
    }

    public function reservedBy()
    {
        return $this->belongsTo(User::class, 'reserved_by');
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
