<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property string $username
 * @property string $url
 * @property int $downloads
 *
 * @method static Builder popular()
 * @method static Builder prunable()
 */
class Video extends Model
{
    use HasCoverImage;

    protected $fillable = [
        'id',
        'username',
        'url',
        'cover',
        'downloads',
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    public function scopePopular(Builder $query): Builder
    {
        return $query->orderBy('downloads', 'desc');
    }

    public function scopePrunable(Builder $query): Builder
    {
        return $query->where('updated_at', '<=', now()->subMonth());
    }
}
