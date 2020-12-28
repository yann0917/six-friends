<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ArchiveStar extends Model
{
    use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'archive_star';
    protected $fillable = ['name'];


    /**
     * @return HasMany
     */
    public function docs():HasMany
    {
        return $this->hasMany(ArchiveDoc::class, 'star_id', 'id');
    }
}
