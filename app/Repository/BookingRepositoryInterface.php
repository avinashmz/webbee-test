<?php


namespace App\Repository;

use App\Models\Booking;
use Illuminate\Support\Collection;

interface BookingRepositoryInterface
{
    /**
     * @param  array|string[]  $columns
     * @param  array  $relation
     *
     * @return Collection
     */
    public function all(array $columns = ['*'], array $relation = []): Collection;
}