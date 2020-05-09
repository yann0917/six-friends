<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class Statement extends Model
{
    use HasDateTimeFormatter;

    public function category()
    {
        return $this->belongsTo(AccountCategory::class);
    }

    public static function getType(): array
    {
        return [
            1 => '收入',
            2 => '支出',
        ];
    }
}
