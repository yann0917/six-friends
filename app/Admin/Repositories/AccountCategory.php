<?php

namespace App\Admin\Repositories;

use Dcat\Admin\Repositories\EloquentRepository;
use App\Models\AccountCategory as AccountCategoryModel;

class AccountCategory extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = AccountCategoryModel::class;

    public static function getBaseCate(): array
    {
        return AccountCategoryModel::getBaseCate();
    }
}
