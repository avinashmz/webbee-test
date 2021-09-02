<?php


namespace App\Repository\Eloquent;


use App\Models\Event;
use Illuminate\Support\Collection;
use App\Repository\EventRepositoryInterface;

class EventRepository extends BaseRepository implements EventRepositoryInterface
{

    /**
     * EventRepository constructor.
     *
     * @param Event $model
     */
    public function __construct(Event $model)
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