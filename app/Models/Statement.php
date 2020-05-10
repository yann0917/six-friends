<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
