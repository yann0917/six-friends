<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Statement;
use App\Models\AccountCategory;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class StatementController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Statement(), function (Grid $grid) {
            $grid->disableBatchDelete();
            $grid->disableDeleteButton();

            $grid->model()->with(['category']);
            $grid->id->sortable();
            $grid->date;
            $grid->money->help('人民币：元');
            $grid->column('category_name', '分类')->display(function () {
                return $this->category['name'];
            });
            $grid->type->using([1=>'收入', 2=>'支出'])->sortable();
            $grid->memo;
            $grid->created_at;
            // $grid->updated_at->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->panel();
                $filter->equal('id')->width(3);
                $filter->between('date')->datetime(['format' => 'YYYY-MM-DD'])->width(3);
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
        return Show::make($id, new Statement(), function (Show $show) {
            $show->disableDeleteButton();

            $show->id;
            $show->date;
            $show->money;
            $show->type->using([1=>'收入', 2=>'支出']);
            $show->category_id;
            $show->memo;
            $show->created_at;
            // $show->updated_at;
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Statement(), function (Form $form) {
            $form->disableDeleteButton();

            $form->display('id');
            $form->date('date')->required();
            $form->currency('money')
                ->symbol('￥')
                ->required();
            $form->select('type')
                ->options([1=>'收入',2=>'支出'])
                ->load('category_id', '/api/account_category')
                ->required();
            $form->select('category_id', '分类')
                ->required();
            $form->textarea('memo')
                ->rows(10)
                ->required();
            $form->display('created_at');
            // $form->display('updated_at');
        });
    }
}
