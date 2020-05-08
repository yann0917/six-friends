<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Columnist;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use DemeterChain\C;

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
            $grid->gender->using(Columnist::getGender())
                ->label([0 => 'info', 1 => 'success']);
            $grid->type->using(Columnist::getType(), '未知');
            $grid->column('remuneration', '稿费总额')->display(function (){
                // TODO:
                return 100;
            });
            $grid->bio->limit(50, '...');;
            $grid->phone;
            $grid->email;
            $grid->score->sortable();
            $grid->status
                ->using(Columnist::getStatus())
                ->filter(
                    Grid\Column\Filter\In::make(Columnist::getStatus())
                );
            $grid->created_at;

            $grid->filter(function (Grid\Filter $filter) {
                $filter->panel();
                $filter->equal('id')->width(3);
                $filter->like('nickname')->width(3);
                $filter->equal('type')
                    ->select(Columnist::getType())
                    ->default(1)
                    ->width(3);
                $filter->equal('status')
                    ->select(Columnist::getStatus())
                    ->default(1)
                    ->width(3);
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
            $show->gender->using(Columnist::getGender());
            $show->type->using(Columnist::getType(), '未知');
            $show->bio;
            $show->phone;
            $show->email;
            $show->score;
            $show->status->using(Columnist::getStatus());
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
                ->options(Columnist::getGender())
                ->width(4)->required();
            $form->select('type')
                ->options(Columnist::getType())
                ->width(4)
                ->required();
            $form->textarea('bio')
                ->rows(10)
                ->required();
            $form->mobile('phone')
                ->options(['mask' => '999 9999 9999'])
                ->width(4);
            $form->email('email')->width(4);
            $form->number('score')
                ->min(0)
                ->max(10)->width(4);
            $form->select('status')
                ->options(Columnist::getStatus())
                ->width(4)
                ->required();
            $form->display('created_at')->width(4);
            $form->display('updated_at')->width(4);
        });
    }
}
