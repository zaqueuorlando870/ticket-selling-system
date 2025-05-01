<?php
namespace App\Services;

use App\Repositories\EventRepositoryInterface;
use Illuminate\Support\Facades\Cache;


class EventDataService
{
    const EVENT_DATA_CACHE_KEY = 'event_data';
    const EVENT_DATA_CACHE_TTL = 60; // 1 minute

    private $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function getEventData($eventId)
    {
        $cacheKey = self::EVENT_DATA_CACHE_KEY . '_' . $eventId;
        $eventData = Cache::get($cacheKey);

        if (!$eventData) {
            $eventData = $this->eventRepository->find($eventId);
            Cache::put($cacheKey, $eventData, self::EVENT_DATA_CACHE_TTL);
        }

        return $eventData;
    }

    
    public function getAllEvents()
    {
        $cacheKey = self::EVENT_DATA_CACHE_KEY . '_all';
        $events = Cache::get($cacheKey);

        if (!$events) {
            $events = $this->eventRepository->all();
            Cache::put($cacheKey, $events, self::EVENT_DATA_CACHE_TTL);
        }

        return $events;
    }

    
    public function updateEvent($eventId, $data)
    {
        $cacheKey = self::EVENT_DATA_CACHE_KEY . '_' . $eventId;
        Cache::forget($cacheKey);

        $this->eventRepository->update($eventId, $data);
    }
}

