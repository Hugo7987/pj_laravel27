<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Classe générée automatiquement par db2laravel.
 *
 * Ne pas modifier directement cette classe : elle peut être régénérée.
 */
abstract class RoleBase extends Model
{
    protected $table = 'roles';

    protected $fillable = [
        'code',
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
            'id_role',
            'id'
        );
    }

    public function utilisateurs(): HasMany
    {
        return $this->hasMany(
            \App\Models\Utilisateur::class,
            'id_role',
            'id'
        );
    }

    public function actions(): BelongsToMany{
        return $this->belongsToMany(Action::class);
    }
}
