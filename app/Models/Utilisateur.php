<?php

namespace App\Models;

use App\Models\Base\UtilisateurBase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Utilisateur extends UtilisateurBase
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public function hasAutorisation(string $action): bool
    {
        return $this->role()
            ->whereHas('actions', function ($query) use ($action) {
                $query->where('nom', $action);
            })
            ->exists();
    }
}
