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


}