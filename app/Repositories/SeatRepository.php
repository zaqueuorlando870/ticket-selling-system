<?php 

namespace App\Repositories;

use App\Models\Seat;

class SeatRepository implements SeatRepositoryInterface
{
    public function all()
    {
        return Seat::all();
    }

    public function find($id)
    {
        return Seat::find($id);
    }

    public function findWhere($eventId = null, $seatId = null, $isReserved = null)
    {
        $query = Seat::query();

        if ($seatId) {
            $query->where('id', $seatId);
        }

        if ($eventId) {
            $query->where('event_id', $eventId);
        }

        if ($eventId) {
            $query->where('is_reserved', $isReserved);
        }

        return $query->first();
    }

    public function create($data)
    {
        return Seat::create($data);
    }

    public function update($id, $data)
    {
        $seat = $this->find($id);
        $seat->update($data);
        return $seat;
    }

    public function delete($id)
    {
        $seat = $this->find($id);
        $seat->delete();
        return true;
    }
}
