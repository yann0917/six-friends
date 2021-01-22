<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Message;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class MessageController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Message(), function (Grid $grid) {
            $grid->model()->orderByDesc('created_at');
            $grid->disableDeleteButton();
            $grid->disableRowSelector();
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $admin_uid = $actions->row->admin_uid;
                if ($admin_uid != Admin::user()->id) {
                    $actions->disableEdit();
                }
            });

            $grid->id->sortable();
            $grid->title;
            $grid->content->limit(50, '...');
            $grid->created_at;

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id')->width(3);
                $filter->like('title')->width(3);
                $filter->like('content')->width(3);
            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new Message(), function (Show $show) {
            $show->disableDeleteButton();
            $show->disableEditButton();

            $show->id;
            $show->title;
            $show->content;
            $show->created_at;
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Message(), function (Form $form) {
            $form->disableDeleteButton();

            $form->display('id');
            $form->text('title');
            $form->textarea('content');

            $form->display('created_at');

            $form->hidden('admin_uid');
            $form->saving(function (Form $form) {
                if ($form->isCreating()) {
                    $form->input('admin_uid', Admin::user()->id);
                }
            });
        });
    }
}
