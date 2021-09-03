<?php


namespace App\Repository;

use App\Models\Event;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

interface EventRepositoryInterface
{
    /**
     * @param  int  $id
     * @param  array|string[]  $columns
     * @param  array  $relations
     * @param  array  $appends
     *
     * @return Model|null
     */
    public function find(int $id, array $columns=['*'], array $relations=[], array $appends = []): ?Model;
}