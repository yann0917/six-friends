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
        return Grid::make(new ArchiveDoc(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('title');
            $grid->column('reading');
            $grid->column('link');
            $grid->column('remark');
            $grid->column('publish_at');
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
        return Show::make($id, new ArchiveDoc(), function (Show $show) {
            $show->field('id');
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
        return Form::make(new ArchiveDoc(), function (Form $form) {
            $form->display('id');
            $form->text('title');
            $form->text('reading');
            $form->text('link');
            $form->text('remark');
            $form->text('publish_at');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
