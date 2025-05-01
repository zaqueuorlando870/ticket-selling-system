<?php 

namespace App\Repositories;

use App\Models\Event;

class EventRepository implements EventRepositoryInterface
{
    public function all()
    {
        return Event::all();
    }

    public function find(int $id)
    {
        return Event::find($id);
    }

    public function create(array $data)
    {
        return Event::create($data);
    }

    public function update(int $id, array $data)
    {
        $event = $this->find($id);
        $event->update($data);
        return $event;
    }

    public function delete(int $id)
    {
        $event = $this->find($id);
        $event->delete();
        return true;
    }
}

