<?php

namespace App\Admin\Repositories;

use Dcat\Admin\Form;
use Dcat\Admin\Repositories\EloquentRepository;
use App\Models\Statement as StatementModel;

class Statement extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = StatementModel::class;

    /**
     * @param Form $form
     * @return array
     */
    public function edit(Form $form): array
    {
        $form = parent::edit($form);
        $form['money'] *= 0.01;
        return $form;
    }

    public static function getType(): array
    {
        return StatementModel::getType();
    }
}
