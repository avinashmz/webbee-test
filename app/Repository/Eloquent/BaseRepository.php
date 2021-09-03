<?php


namespace App\Repository\Eloquent;


use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Repository\EloquentRepositoryInterface;

class BaseRepository implements EloquentRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $attributes
     *
     * @return Model
     */
    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    /**
     * @param $id
     * @return Model
     */
    public function find(int $id, array $columns = ['*'], array $relations = [], array $appends = []): ?Model
    {
        return $this->model->select($columns)->with($relations)->findOrFail($id)->append($appends);
    }


    /**
     * @param  array  $columns
     * @param  array  $relation
     *
     * @return Collection
     */
    public function all(array $columns = ['*'], array $relation = []): Collection
    {
        return $this->model->with($relation)->get($columns);
    }

    /**
     * @param  Model  $model
     * @param  array  $data
     *
     * @return void
     */
    public function createOrUpdate(Model &$model, $data) {
        $model->fill($data)->save();

    }

}