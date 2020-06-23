<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Announce;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class AnnounceController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Announce(), function (Grid $grid) {
            $grid->disableDeleteButton();
            $grid->model()->orderByDesc('created_at');
            $grid->id->sortable();
            $grid->title;
            $grid->content->limit(50, '...');
            $grid->created_at;

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
        return Show::make($id, new Announce(), function (Show $show) {
            $show->disableDeleteButton();
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
        return Form::make(new Announce(), function (Form $form) {
            $form->disableDeleteButton();
            $form->display('id');
            $form->text('title');
            $form->textarea('content');

            $form->display('created_at');
            $form->display('updated_at');
            $form->hidden('admin_uid');
            $form->saving(function (Form $form) {
                if ($form->isCreating()) {
                    $form->input('admin_uid', Admin::user()->id);

                }
            });
            $form->submitted(function (Form $form) {
                $title = $form->title;
                $content = $form->content;
                if ($content) {
                    // 钉钉通知
                    ding()->at([], true)->text('【'.$title."】\n\n".$content);
                }
            });
        });
    }
}
