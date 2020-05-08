<?php

namespace App\Admin\Repositories;

use Dcat\Admin\Repositories\EloquentRepository;
use App\Models\Columnist as ColumnistModel;

class Columnist extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = ColumnistModel::class;

    public static function getStatus(): array
    {
        return ColumnistModel::getStatus();
    }

    public static function getGender(): array
    {
        return ColumnistModel::getGender();
    }

    public static function getType(): array
    {
        return ColumnistModel::getType();
    }
}
