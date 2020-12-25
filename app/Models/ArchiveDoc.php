<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ArchiveDoc extends Model
{
    use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'archive_doc';


    /**
     * @return BelongsTo
     */
    public function star():BelongsTo
    {
        return $this->belongsTo(ArchiveStar::class, 'star_id');
    }

    /**
     * @return BelongsToMany
     */
    public function tags():BelongsToMany
    {
        return $this->belongsToMany(ArchiveTag::class,
            'archive_doc_tag',
            'doc_id', 'tag_id');
    }

}
