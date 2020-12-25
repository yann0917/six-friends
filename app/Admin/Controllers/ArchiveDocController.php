<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\ArchiveDoc;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class ArchiveDocController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new ArchiveDoc(['star', 'tags']), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('star_name', '姓名')->display(function () {
                return $this->star['name'];
            });
            $grid->column('title');
            $grid->column('reading');
            $grid->column('link');
            $grid->column('remark');
            $grid->column('publish_at');
            $grid->tags('标签')->pluck('name')->label();
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

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
        return Show::make($id, new ArchiveDoc(['star', 'tags']), function (Show $show) {
            $show->field('id');
            $show->star('姓名')->get('name');
            $show->field('title');
            $show->field('reading');
            $show->field('link');
            $show->field('remark');
            $show->field('publish_at');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new ArchiveDoc(['star', 'tags']), function (Form $form) {
            $form->display('id');
            $form->text('star.name')->label('姓名');
            $form->text('title');
            $form->text('reading');
            $form->text('link');
            $form->text('remark');
            $form->datetime('publish_at');
            // $form->text('tags')
            //     ->customFormat(function ($v) {
            //     if (!$v) return [];
            //     return array_column($v, 'id');
            // });

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
