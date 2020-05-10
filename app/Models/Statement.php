<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Statement extends Model
{
    use HasDateTimeFormatter;

    /**
     * 账单分类
     *
     * @return BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(AccountCategory::class);
    }

    /**
     * 写手
     *
     * @return BelongsTo
     */
    public function columnist()
    {
        return $this->belongsTo(Columnist::class);
    }

    public static function getType(): array
    {
        return [
            1 => '收入',
            2 => '支出',
        ];
    }

    public function statByColumnistId(int $columnist_id): int
    {
        $stat = $this->select(DB::raw('SUM(money) as count'))
            ->where('columnist_id', $columnist_id)
            ->first();
        return $stat->count ?: 0;

    }
}
