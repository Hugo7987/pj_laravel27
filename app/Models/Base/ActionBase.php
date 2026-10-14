<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Classe générée automatiquement par db2laravel.
 *
 * Ne pas modifier directement cette classe : elle peut être régénérée.
 */
abstract class ActionBase extends Model
{
    protected $table = 'actions';

    protected $fillable = [
        'nom',
        'commentaire',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function autoriser(): HasMany
    {
        return $this->hasMany(
            \App\Models\Autoriser::class,
            'id_action',
            'id'
        );
    }

    public function roles(): BelongsToMany{
        return $this->belongsToMany(Role::class);
    }
}
