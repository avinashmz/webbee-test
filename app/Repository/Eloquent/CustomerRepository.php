<?php


namespace App\Repository\Eloquent;


use App\Models\Customer;
use Illuminate\Support\Collection;
use \App\Repository\CustomerRepositoryInterface;

class CustomerRepository extends BaseRepository implements CustomerRepositoryInterface
{

    /**
     * UserRepository constructor.
     *
     * @param Customer $model
     */
    public function __construct(Customer $model)
    {
        parent::__construct($model);
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->all();
    }
}