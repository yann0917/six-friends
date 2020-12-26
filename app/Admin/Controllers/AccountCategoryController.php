<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\AccountCategory;
use App\Admin\Repositories\Statement;
use App\Models\AccountCategory as ModelsAccountCategory;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountCategoryController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new AccountCategory(), function (Grid $grid) {
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $id = $actions->row->id;
                if (in_array($id, array_keys(AccountCategory::getBaseCate()))) {
                    $actions->disableEdit();
                    $actions->disableDelete();
                }
            });
            $grid->id->sortable();
            $grid->name;
            $grid->type->using(Statement::getType())
                ->label([1 => 'success', 2 => 'danger'])
                ->filter(Grid\Column\Filter\In::make(Statement::getType()));
            $grid->created_at;

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id')->width(3);
                $filter->like('name')->width(3);
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
        return Show::make($id, new AccountCategory(), function (Show $show) {
            $show->panel()
                ->tools(function (Show\Tools $tools) {
                    $tools->disableEdit();
                    $tools->disableDelete();
                });

            $show->id;
            $show->name;
            $show->type->using(Statement::getType());
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
        return Form::make(new AccountCategory(), function (Form $form) {
            $form->display('id')->width(3);
            $form->text('name')->width(3)->required();
            $form->select('type')
                ->options(Statement::getType())
                ->width(3)
                ->required();

            $form->display('created_at')->width(3);
            $form->display('updated_at')->width(3);
        });
    }

    public function category(Request $request)
    {
        $type = $request->get('q');
        return ModelsAccountCategory::where('type', $type)
            ->get(['id', DB::raw('name as text')]);
    }
}
