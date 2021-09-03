<?php


namespace App\Repository;

use App\Models\Customer;
use Illuminate\Support\Collection;

interface CustomerRepositoryInterface
{
    /**
     * @param  array|string[]  $columns
     * @param  array  $relation
     *
     * @return Collection
     */
    public function all(array $columns = ['*'], array $relation = []): Collection;
}