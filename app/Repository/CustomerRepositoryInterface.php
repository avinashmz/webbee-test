<?php


namespace App\Repository;

use App\Models\Customer;
use Illuminate\Support\Collection;

interface CustomerRepositoryInterface
{
    public function all(array $columns = ['*'], array $relation = []): Collection;
}