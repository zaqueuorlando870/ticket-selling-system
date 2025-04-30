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
}
