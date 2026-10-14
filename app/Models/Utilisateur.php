<?php

namespace App\Models;

use App\Models\Base\UtilisateurBase;

class Utilisateur extends UtilisateurBase {
    public function hasAutorisation(string $action): bool{
        return $this->role()
            ->whereHas('actions', function ($query) use ($action){
                $query->where('nom', $action);
            })
            ->exists();
    }
}
