<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ArchiveDocTag extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'archive_doc_tag';
    protected $fillable = ['doc_id', 'tag_id'];

}
