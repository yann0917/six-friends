<?php

namespace App\Exports;

use App\Models\Statement;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StatementExport implements FromQuery, WithHeadings, WithMapping
{
    protected $rows;

    /**
     * @inheritDoc
     */
    public function query()
    {
        return Statement::query()->with(['category', 'columnist'])
            ->orderByDesc('created_at');
    }

    /**
     * @inheritDoc
     */
    public function headings(): array
    {
        return [
            'id', '日期', '金额', '类型', '分类', '交易快照', '写手', '字数统计', '发文数量', '备注', '创建时间',
        ];
    }

    /**
     * @inheritDoc
     */
    public function map($row): array
    {
        return [
            $row->id,
            $row->date,
            $row->money * 0.01,
            $row->category->name,
            $row->type == 1 ? '收入' : '支出',
            $row->snapshot ? env('APP_URL') .'/uploads/'. $row->snapshot : '',
            $row->columnist ? $row->columnist->nickname : '',
            $row->words_count,
            $row->article_num,
            $row->memo,
            $row->created_at,
        ];
    }
}
