<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;
    protected $fillable = ['label', 'event_id', 'is_reserved', 'is_sold'];

    public function isAvailable()
    {
        return !$this->is_reserved && !$this->is_sold;
    }

    public function isReserved()
    {
        return $this->is_reserved && !$this->is_sold;
    }

    public function isSold()
    {
        return $this->is_sold;
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
