<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Columnist;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class ColumnistController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Columnist(), function (Grid $grid) {
            $grid->id->sortable();
            $grid->nickname;
            $grid->gender->using([0 => '女', 1 => '男'])
                ->label([0 => 'info', 1 => 'success']);
            $grid->phone;
            $grid->email;
            $grid->score->sortable();
            $grid->created_at;
            $grid->updated_at->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new Columnist(), function (Show $show) {
            $show->id;
            $show->nickname;
            $show->gender->using([0 => '女', 1 => '男']);
            $show->phone;
            $show->email;
            $show->score;
            $show->created_at;
            $show->updated_at;
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Columnist(), function (Form $form) {
            $form->display('id')->width(4);
            $form->text('nickname')->width(4)->required();
            $form->select('gender')
                ->options([0 => '女', 1 => '男'])
                ->width(4)->required();
            $form->mobile('phone')
                ->options(['mask' => '999 9999 9999'])
                ->width(4);
            $form->email('email')->width(4);
            $form->number('score')
                ->min(0)
                ->max(10)->width(4);

            $form->display('created_at')->width(4);
            $form->display('updated_at')->width(4);
        });
    }
}
