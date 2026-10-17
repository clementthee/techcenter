<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Vínculo entre un usuario de TechCenter y una cuenta externa.
 * provider es google, microsoft o github. provider_id es el id que da ese servicio.
 */
class SocialAccount extends Model
{
    protected $fillable = [
        'provider',
        'provider_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
