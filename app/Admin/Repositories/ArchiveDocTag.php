<?php

namespace App\Admin\Repositories;

use App\Models\ArchiveDocTag as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class ArchiveDocTag extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
