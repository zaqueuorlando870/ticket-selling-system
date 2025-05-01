<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Event extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;

    const STATUS_UPCOMING = 'upcoming';
    const STATUS_LIVE = 'live';
    const STATUS_COMPLETED = 'completed';
    protected $table = 'events';

    protected $fillable = [
        'title',
        'description',
        'price',
        'event_date',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function seats()
    {
        return $this->hasMany(Seat::class, 'event_id');
    }

    public function generateSeats()
    {
        $rows = range('A', 'J');
        $cols = range(1, 10);

        foreach ($rows as $row) {
            foreach ($cols as $col) {
                $this->seats()->create(['label' => $row . $col]);
            }
        }
    }

    public function attendees()
    {
        return $this->belongsToMany(User::class, 'attendees')
            ->whereHas('roles', function ($query) {
                $query->where('name', 'attendee');
            });
    }

    public function scopeUpcoming($query)
    {
        return $query->where('status', self::STATUS_UPCOMING);
    }

    public function scopeLive($query)
    {
        return $query->where('status', self::STATUS_LIVE);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }
}
