<?php


namespace App\Repository;

use App\Models\Booking;
use Illuminate\Support\Collection;

interface BookingRepositoryInterface
{
    public function all(): Collection;
}