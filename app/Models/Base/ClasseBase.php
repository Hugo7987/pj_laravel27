<?php

namespace App\Models\Base;

use App\Models\Enseigner;
use App\Models\Photo;
use App\Models\Utilisateur;
use Illuminate\Database\Eloquent\Model;

/**
 * Classe générée automatiquement par db2laravel.
 *
 * Ne pas modifier directement cette classe : elle peut être régénérée.
 */
abstract class ClasseBase extends Model
{
    protected $table = 'classes';

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

    public function enseigner(): HasMany
    {
        return $this->hasMany(
            Enseigner::class,
            'id_classe',
            'id'
        );
    }

    public function photos(): HasMany
    {
        return $this->hasMany(
            Photo::class,
            'id_classe',
            'id'
        );
    }

    public function utilisateurs(): HasMany
    {
        return $this->hasMany(
            Utilisateur::class,
            'id_classe',
            'id'
        );
    }
}
