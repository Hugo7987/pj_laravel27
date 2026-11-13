<?php

namespace App\Models\Base;

use App\Models\Autoriser;
use App\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
            Autoriser::class,
            'id_action',
            'id'
        );
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'autoriser', 'id_action', 'id_role');
    }
}
