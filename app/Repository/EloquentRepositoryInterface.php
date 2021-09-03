<?php


namespace App\Repository;


use Illuminate\Database\Eloquent\Model;

/**
 * Interface EloquentRepositoryInterface
 * @package App\Repositories
 */
interface EloquentRepositoryInterface
{
    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model;

    /**
     * @param $id
     * @return Model
     */
    public function find(int $id, array $columns=['*'], array $relations=[], array $appends = []): ?Model;

    /**
     * @param  Model  $model
     * @param  array  $data
     *
     * @return void
     */
    public function createOrUpdate(Model &$model, array $data);
}
