<?php
/**
 * @Author: zhaoyabo
 * @Date  : 2020/5/14 15:51
 * @Last  Modified by: zhaoyabo
 * @Last  Modified time: 2020/5/14 15:51
 */

namespace App\Admin\Extensions\Tools;

use Dcat\Admin\Admin;
use Dcat\Admin\Grid\Tools\AbstractTool;

class StatementExport extends AbstractTool
{
    protected function script()
    {

        $url = admin_base_path('statement/export');
        return <<<JS
$("#statement-export").attr("action", "$url")
JS;
    }

    public function render()
    {
        Admin::script($this->script());
        return view('admin.tools.statement-export');
    }
}
