<?php


namespace App\Repository;

use App\Models\Event;
use Illuminate\Support\Collection;

interface EventRepositoryInterface
{
    public function all(): Collection;
}