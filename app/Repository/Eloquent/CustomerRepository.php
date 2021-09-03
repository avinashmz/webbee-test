<?php


namespace App\Repository\Eloquent;


use App\Models\Customer;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use \App\Repository\CustomerRepositoryInterface;

class CustomerRepository extends BaseRepository implements CustomerRepositoryInterface
{

    /**
     * CustomerRepository constructor.
     *
     * @param Customer $model
     */
    public function __construct(Customer $model)
    {
        parent::__construct($model);
    }

    /**
     * @param  array  $columns
     * @param  array  $relation
     *
     * @return Collection
     */
    public function all(array $columns = ['*'], array $relation = []): Collection
    {
        return $this->model->all();
    }


    /**
     * @param  string  $email
     *
     * @return Model
     */
    public function findByEmail(string $email): ?Model
    {
        $where = [
            'email' => $email
        ];

        return $this->model->where($where)->firstOrNew();
    }



}