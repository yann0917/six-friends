<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ArchiveTag extends Model
{
    use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'archive_tag';

    /**
     * @return BelongsToMany
     */
    public function docs()
    {
        return $this->belongsToMany(ArchiveDoc::class,
            'archive_doc_tag',
            'tag_id', 'doc_id');
    }

}
