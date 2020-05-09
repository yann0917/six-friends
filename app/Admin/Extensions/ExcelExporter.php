<?php
/**
 * @Author: zhaoyabo
 * @Date  : 2020/5/9 16:00
 * @Last  Modified by: zhaoyabo
 * @Last  Modified time: 2020/5/9 16:00
 */

namespace App\Admin\Extensions;

use App\Exports\ColumnistExport;
use Dcat\Admin\Grid\Exporters\AbstractExporter;
use Maatwebsite\Excel\Facades\Excel;

class ExcelExporter extends AbstractExporter
{

    /**
     * @inheritDoc
     */
    public function export()
    {
        $fileName = '写手列表'.date('Y-m-d-H-i-s').'.xlsx';
        return Excel::download(new ColumnistExport(), $fileName);
    }
}
