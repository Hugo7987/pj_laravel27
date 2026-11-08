<?php

namespace App\Models\Base;

use App\Models\Classe;
use App\Models\Utilisateur;
use Illuminate\Database\Eloquent\Model;

/**
 * Classe générée automatiquement par db2laravel.
 *
 * Ne pas modifier directement cette classe : elle peut être régénérée.
 */
abstract class EnseignerBase extends Model
{
    protected $table = 'enseigner';

    // ATTENTION : clé primaire composite détectée : id_utilisateur, id_classe

    // Eloquent ne gère pas nativement les clés primaires composites.

    public $incrementing = false;

    protected $fillable = [
        'id_utilisateur',
        'id_classe',
    ];

    protected function casts(): array
    {
        return [
            'id_utilisateur' => 'integer',
            'id_classe' => 'integer',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(
            Utilisateur::class,
            'id_utilisateur',
            'id'
        );
    }

    public function classe(): BelongsTo
    {
        return $this->belongsTo(
            Classe::class,
            'id_classe',
            'id'
        );
    }
}
