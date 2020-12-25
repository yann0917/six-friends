<?php

namespace App\Admin\Repositories;

use App\Models\ArchiveStarDoc as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class ArchiveStarDoc extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
