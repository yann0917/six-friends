<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class AccountCategory extends Model
{
    use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'account_category';

    public static function getBaseCate(): array
    {
        return [
            1 => '股东投资',
            2 => '公费支出',
            3 => '稿费',
            4 => '文章阅读奖励',
        ];
    }


}
