<?php

use App\Admin\Extensions\WangEditor;
use Dcat\Admin\Admin;
use Dcat\Admin\Grid;
use Dcat\Admin\Form;
use Dcat\Admin\Grid\Filter;
use Dcat\Admin\Show;

/**
 * Dcat-admin - admin builder based on Laravel.
 *
 * @author jqh <https://github.com/jqhph>
 * Bootstraper for Admin.
 * Here you can remove builtin form field:
 * extend custom field:
 * Dcat\Admin\Form::extend('php', PHPEditor::class);
 * Dcat\Admin\Grid\Column::extend('php', PHPEditor::class);
 * Dcat\Admin\Grid\Filter::extend('php', PHPEditor::class);
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 */
// 监听表格初始化事件
Grid::resolving(function (Grid $grid) {
    $grid->disableBatchDelete(); // 禁用批量删除
    $grid->disableRowSelector(); // 禁用行选择器

    $grid->filter(function (Grid\Filter $filter){
        $filter->panel();
    });
});

// 注册 WangEditor
// Form::extend('editor', WangEditor::class);
