<?php


namespace App\Repository;

use App\Models\Event;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

interface EventRepositoryInterface
{
    public function find(int $id, array $columns=['*'], array $relations=[], array $appends = []): ?Model;
}