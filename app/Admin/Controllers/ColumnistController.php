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
            $grid->model()->orderByDesc('created_at');
            $grid->id->sortable();
            $grid->nickname;
            $grid->gender->using(Columnist::getGender())
                ->label([0 => 'success', 1 => 'danger']);
            $grid->type->using(Columnist::getType(), '未知');
            $grid->column('remuneration', '稿费总额')->display(function () {
                // TODO:
                return 100;
            });
            $grid->bio->limit(50, '...');
            $grid->wechat_account;
            $grid->qq_account;
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
            $show->divider();
            $show->wechat_account;
            $show->qq_account;
            $show->phone;
            $show->email;
            $show->divider();
            $show->score;
            $show->status
                ->using(Columnist::getStatus())
                ->dot([0 => 'danger', 1 => 'success', 2 => 'secondary', 3 => 'warning']);
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
            $form->tab('基本信息', function (Form $form) {
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
                    ->rows(8)
                    ->required();
                $form->slider('score')
                    ->options(['max' => 10, 'min' => 0, 'step' => 1, 'postfix' => '分数'])
                    ->width(4);
                $form->select('status')
                    ->options(Columnist::getStatus())
                    ->width(4)
                    ->required();
                $form->display('created_at')->width(4);
                $form->display('updated_at')->width(4);
            })->tab('联系方式', function (Form $form) {
                $form->text('wechat_account')
                    ->width(4)
                    ->default('');
                $form->text('qq_account')
                    ->width(4)
                    ->default('');
                $form->mobile('phone')
                    ->options(['mask' => '999 9999 9999'])
                    ->width(4)
                    ->default('');
                $form->email('email')
                    ->width(4)
                    ->default('');
            });
        });
    }
}
