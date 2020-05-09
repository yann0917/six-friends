<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Statement;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use App\Models\Columnist as ModelsColumnist;

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
            $grid->disableDeleteButton();
            $grid->model()->orderByDesc('created_at');

            $grid->model()->with(['category']);
            $grid->id->sortable();
            $grid->date;
            $grid->column('money')->display(function () {
                return $this->money * 0.01;
            })->help('人民币：元')->sortable();
            $grid->column('category_name', '分类')->display(function () {
                return $this->category['name'];
            });
            $grid->type->using(Statement::getType())
                ->label([1 => 'success', 2 => 'danger'])
                ->sortable();
            $grid->snapshot->image();
            $grid->columnist_id;
            $grid->words_count;
            $grid->article_num;
            $grid->memo->limit(25, '...');
            $grid->created_at;

            $grid->filter(function (Grid\Filter $filter) {
                $filter->panel();
                $filter->equal('id')->width(3);
                // $filter->like('columnist_nickname')->width(3);
                $filter->between('date')->datetime(['format' => 'YYYY-MM-DD'])->width(3);
                $filter->where('money', function ($query) {
                    $input = $this->input * 100;
                    $query->where('money', '=', "{$input}");
                })->width(3);
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
        return Show::make($id, new Statement(['category']), function (Show $show) {
            $show->disableDeleteButton();

            $show->id;
            $show->date;
            $show->money->as(function ($money) {
                return $money * 0.01;
            });
            $show->type->using(Statement::getType());
            $show->category('分类')->get('name');
            $show->snapshot->image();
            if ($show->model()->columnist_id) {
                $show->columnist_id;
                $show->words_count;
                $show->article_num;
            }
            $show->memo;
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
        return Form::make(new Statement(), function (Form $form) {
            $form->disableDeleteButton();
            $form->disableResetButton();
            // 设置默认卡片宽度
            $form->setDefaultBlockWidth(6);

            $form->display('id');
            $form->date('date')->required();
            $form->number('money')->default(1)
                ->required();
            $form->select('type')
                ->options(Statement::getType())
                ->load('category_id', '/api/account_category')
                ->required();
            $form->select('category_id', '分类')
                ->required();
            $form->textarea('memo')
                ->rows(10)
                ->placeholder('请填写备注如进账说明，支出说明等')
                ->required();
            $form->image('snapshot');
            // 分块显示
            $form->block(6, function (Form\BlockForm $form) {
                $form->title('写手费用信息');

                $form->selectResource('columnist_id', '写手昵称')
                    ->path('columnist') // 设置表格页面链接
                    ->options(function ($v) { // 显示已选中的数据
                        if (!$v) return $v;
                        return ModelsColumnist::findOrFail($v)->pluck('nickname', 'id');
                    });

                $form->number('words_count');
                $form->number('article_num');
            });

            $form->display('created_at');
            // $form->display('updated_at');
            $form->saving(function (Form $form) {
                $form->money *= 100; // 存储分
            });
        });
    }
}
