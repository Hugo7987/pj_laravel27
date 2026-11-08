<?php

namespace App\Models\Base;

use App\Models\Utilisateur;
use Illuminate\Database\Eloquent\Model;

/**
 * Classe générée automatiquement par db2laravel.
 *
 * Ne pas modifier directement cette classe : elle peut être régénérée.
 */
abstract class StatutBase extends Model
{
    protected $table = 'statuts';

    protected $primaryKey = 'code';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'code',
        'nom',
        'commentaire',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function utilisateurs(): HasMany
    {
        return $this->hasMany(
            Utilisateur::class,
            'code_statut',
            'code'
        );
    }
}
