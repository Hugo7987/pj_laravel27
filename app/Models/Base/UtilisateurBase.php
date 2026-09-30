<?php

namespace App\Models\Base;

use App\Models\Classe;
use App\Models\Enseigner;
use App\Models\Genre;
use App\Models\Photo;
use App\Models\Role;
use App\Models\Statut;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Classe générée automatiquement par db2laravel.
 *
 * Ne pas modifier directement cette classe : elle peut être régénérée.
 */
abstract class UtilisateurBase extends Model
{
    protected $table = 'utilisateurs';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'nom',
        'prenom',
        'classe',
        'adresse',
        'tel_mobile',
        'numero_candidat',
        'commentaire',
        'id_role',
        'code_statut',
        'code_genre',
        'id_classe',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'id_role' => 'integer',
            'id_classe' => 'integer',
        ];
    }

    public function id(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'id',
            'id'
        );
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(
            Role::class,
            'id_role',
            'id'
        );
    }

    public function codeStatut(): BelongsTo
    {
        return $this->belongsTo(
            Statut::class,
            'code_statut',
            'code'
        );
    }

    public function codeGenre(): BelongsTo
    {
        return $this->belongsTo(
            Genre::class,
            'code_genre',
            'code'
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

    public function enseigner(): HasMany
    {
        return $this->hasMany(
            Enseigner::class,
            'id_utilisateur',
            'id'
        );
    }

    public function photos(): HasMany
    {
        return $this->hasMany(
            Photo::class,
            'id_utilisateur',
            'id'
        );
    }
}
