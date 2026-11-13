<?php

namespace App\Policies;

use App\Models\Enseigner;
use App\Models\Photo;
use App\Models\User;

class PhotoPolicy
{
    public function view(User $user, Photo $photo): bool
    {
        $profile = $user->utilisateur;

        if ($profile === null) {
            return false;
        }

        if (
            $user->can('administration.view')
            && $user->can('photos.view')
        ) {
            return true;
        }

        if ($user->can('photos.view')) {
            if ($photo->id_utilisateur === $profile->id) {
                return true;
            }

            $isAssignedAsTeacher = Enseigner::query()
                ->where('id_utilisateur', $profile->id)
                ->exists();

            if (
                ! $isAssignedAsTeacher
                && $profile->classe !== null
                && $photo->classe?->code === $profile->classe
            ) {
                return true;
            }
        }

        if (! $user->can('trombinoscope.view')) {
            return false;
        }

        $classCode = $photo->classe?->code
            ?? $photo->utilisateur?->classe;

        return $classCode !== null
            && Enseigner::query()
                ->where('id_utilisateur', $profile->id)
                ->where('id_classe', $classCode)
                ->exists();
    }
}
