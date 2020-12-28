<?php
/**
 * @Author: zhaoyabo
 * @Date  : 12/27/20 10:12 PM
 * @Last  Modified by: zhaoyabo
 * @Last  Modified time: 12/27/20 10:12 PM
 */

namespace App\Admin\Renderable;


use App\Admin\Repositories\ArchiveTag;
use Dcat\Admin\Grid;
use Dcat\Admin\Grid\LazyRenderable;

class ArchiveTagTable extends LazyRenderable
{

    /**
     * 创建表格.
     *
     * @return Grid
     */
    public function grid(): Grid
    {
        // 获取外部传递的参数
        $id = $this->id;

        return Grid::make(new ArchiveTag(), function (Grid $grid) {
            $grid->column('id');
            $grid->column('name');
            $grid->column('created_at');
            $grid->column('updated_at');

            // 指定行选择器选中时显示的值的字段名称
            // 指定行选择器选中时显示的值的字段名称
            // 指定行选择器选中时显示的值的字段名称
            // 如果表格数据中带有 “name”、“title”或“username”字段，则可以不用设置
            $grid->rowSelector()->titleColumn('name');

            $grid->quickSearch(['id', 'name']);

            $grid->paginate(10);
            $grid->disableActions();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->like('name')->width(4);
            });
        });
    }
}
