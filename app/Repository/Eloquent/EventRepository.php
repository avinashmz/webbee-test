<?php


namespace App\Repository\Eloquent;


use App\Models\Event;
use App\Models\Booking;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Repository\EventRepositoryInterface;

class EventRepository extends BaseRepository implements EventRepositoryInterface
{

    /**
     * EventRepository constructor.
     *
     * @param  Event  $model
     */
    public function __construct(Event $model)
    {
        parent::__construct($model);
    }

    /**
     * @param  int  $event_id
     * @param  string|null  $date
     * @param  string|null  $futureDate
     *
     * @return Collection
     */
    public function getBookings(int $event_id, string $date = null, string $futureDate = null): Collection
    {
        $obj = Booking::where(['event_id' => $event_id])
                      ->select(['date', 'start_time', DB::raw("COUNT('*') as booked_slots")]);


        // When date is passed,
        // It will load bookings data for that particular day only
        if($date !== null) {
            $obj = $obj->whereDate('date', '=', $date);
        }

        // When futureDate is passed,
        // It will load booking data upto the given date
        if($futureDate !== null) {
            $obj = $obj->whereDate('date', '<=', $futureDate);
        }

        return $obj->groupBy('date', 'start_time')
              ->orderBy('date', 'asc')
              ->orderBy('start_time', 'asc')
              ->get();
    }
}