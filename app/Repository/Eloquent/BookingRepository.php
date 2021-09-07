<?php


namespace App\Repository\Eloquent;


use App\Models\Booking;
use Illuminate\Support\Collection;
use App\Repository\BookingRepositoryInterface;

class BookingRepository extends BaseRepository implements BookingRepositoryInterface
{

    /**
     * BookingRepository constructor.
     *
     * @param Booking $model
     */
    public function __construct(Booking $model)
    {
        parent::__construct($model);
    }

    /**
     * @param  int  $event_id
     * @param  string  $date
     * @param  string  $time
     *
     * @return int
     */
    public function getBookingCountBySlot(int $event_id, string $date, string $time): int
    {
        $where = [
            'event_id' => $event_id,
            'date' => $date,
            'start_time' => $time
        ];
        return Booking::where($where)->count();
    }



}