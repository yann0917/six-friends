<?php

namespace App\Admin\Repositories;

use App\Models\ArchiveTag as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class ArchiveTag extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
