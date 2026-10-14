<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;

/**
 * Classe générée automatiquement par db2laravel.
 *
 * Ne pas modifier directement cette classe : elle peut être régénérée.
 */
abstract class AutoriserBase extends Model
{
    protected $table = 'autoriser';

    // ATTENTION : clé primaire composite détectée : id_role, id_action

    // Eloquent ne gère pas nativement les clés primaires composites.

    public $incrementing = false;

    protected $fillable = [
        'id_role',
        'id_action',
        'commentaire',
    ];

    protected function casts(): array
    {
        return [
            'id_role' => 'integer',
            'id_action' => 'integer',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(
            \App\Models\Role::class,
            'id_role',
            'id'
        );
    }

    public function action(): BelongsTo
    {
        return $this->belongsTo(
            \App\Models\Action::class,
            'id_action',
            'id'
        );
    }
}
