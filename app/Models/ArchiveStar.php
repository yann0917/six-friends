<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ArchiveStar extends Model
{
    use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'archive_star';

    /**
     * @return BelongsToMany
     */
    public function docs()
    {
        return $this->belongsToMany(ArchiveDoc::class,
            'archive_star_doc',
            'star_id', 'doc_id');
    }
}
