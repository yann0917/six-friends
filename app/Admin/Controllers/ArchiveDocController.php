<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\ArchiveDoc;
use App\Admin\Repositories\ArchiveTag;
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
            $grid->column('reading')->sortable();
            $grid->column('link');
            $grid->column('remark');
            $grid->column('publish_at');
            $grid->tags('标签')->pluck('name')->label();
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id')->width(3);
                $filter->where('star_name', function ($query) {
                    $query->whereHas('star', function ($query) {
                        $query->where('name', 'like', "%{$this->input}%");
                    });
                }, '姓名')->width(3);
                $filter->like('title')->width(3);
                $filter->where('tag_name', function ($query) {
                    $query->whereHas('tags', function ($query) {
                        $query->where('name', 'like', "%{$this->input}%");
                    });
                }, '文章标签')->width(3);
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
        return Show::make($id, new ArchiveDoc(['star', 'tags']), function (Show $show) {
            $show->field('id');
            $show->star('姓名')->get('name');
            $show->field('title');
            $show->field('reading');
            $show->link()->link();
            $show->field('remark');
            $show->field('publish_at');

            $show->tags('标签', function ($model) {
                $grid = new Grid(new  ArchiveTag());
                $grid->model()->join('archive_doc_tag', function ($join) use ($model) {
                    $join->on('archive_doc_tag.tag_id', 'archive_tag.id')
                        ->where('doc_id', '=', $model->id);
                });

                $grid->resource('tags');

                $grid->id;
                $grid->name;

                $grid->filter(function (Grid\Filter $filter) {
                    $filter->equal('id')->width(3);
                    $filter->like('name')->width(3);
                });
                return $grid;
            });

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
