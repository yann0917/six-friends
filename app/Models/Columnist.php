<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Columnist extends Model
{
    use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'columnist';

    public static function getStatus(): array
    {
        return [
            0 => '淘汰',
            1 => '合作中',
            2 => '暂停合作',
            3 => '终止合作',
        ];
    }

    public static function getGender(): array
    {
        return [
            0 => '女',
            1 => '男',
        ];
    }

    public static function getType(): array
    {
        return [
            1 => '个人',
            2 => '工作室',
        ];
    }

}
