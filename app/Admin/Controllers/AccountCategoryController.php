<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\AccountCategory;
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
            $grid->id->sortable();
            $grid->name;
            $grid->type->using([1 => '收入', 2 => '支出'])
                ->label([1 => 'success', 2 => 'danger']);
            $grid->created_at;
            // $grid->updated_at->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->panel();
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
            $show->id;
            $show->name;
            $show->type->using([1 => '收入', 2 => '支出']);
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
                ->options([1 => '收入', 2 => '支出'])
                ->width(3)
                ->required();

            $form->display('created_at')->width(3);
            $form->display('updated_at')->width(3);
        });
    }

    public function category(Request $request)
    {
        $type = $request->get('q');
        return ModelsAccountCategory::where('type', $type)->get(['id', DB::raw('name as text')]);
    }
}
