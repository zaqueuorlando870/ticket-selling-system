<?php
namespace App\Services;

use App\Repositories\SeatRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Exception;

class SeatReservationService
{
    private SeatRepositoryInterface $seatRepository;

    public function __construct(SeatRepositoryInterface $seatRepository)
    {
        $this->seatRepository = $seatRepository;
    }

    public function reserveSeat(int $seatId, int $userId): void
    {
        DB::transaction(function () use ($seatId, $userId) {
            $seat = $this->seatRepository->find($seatId);

            if (!$seat || $seat->is_reserved || $seat->is_sold) {
                throw new Exception('Seat is not available.');
            }

            $this->seatRepository->update($seat->id, [
                'is_reserved' => true,
                'reserved_by' => $userId,
            ]);
        });
    }

    public function getAvailableSeat(int $seatId, int $eventId, $isReserved = null)
    {
        return $this->seatRepository->findWhere($seatId, $eventId, 0);
    }

    public function find(int $seatId)
    {
        return $this->seatRepository->find($seatId);
    }

    public function getAvailableSeats(int $eventId)
    {
        return $this->seatRepository->findWhere(null, $eventId, 0);
    }
}
