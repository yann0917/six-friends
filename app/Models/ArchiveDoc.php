<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ArchiveDoc extends Model
{
    use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'archive_doc';

    /**
     * @return BelongsToMany
     */
    public function stars()
    {
        return $this->belongsToMany(ArchiveStar::class,
            'archive_star_doc',
            'doc_id', 'star_id');
    }

    /**
     * @return BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(ArchiveTag::class,
            'archive_doc_tag',
            'doc_id', 'tag_id');
    }

}
