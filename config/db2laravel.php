<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Connexion
    |--------------------------------------------------------------------------
    |
    | null signifie que la connexion par défaut de Laravel sera utilisée.
    |
    */

    'connection' => null,

    /*
    |--------------------------------------------------------------------------
    | Tables
    |--------------------------------------------------------------------------
    |
    | Les noms indiqués ici sont les noms logiques, sans préfixe.
    |
    */

    'tables' => [
        'include' => [],

        'exclude' => [
            'cache',
            'cache_locks',
            'failed_jobs',
            'jobs',
            'job_batches',
            'migrations',
            'password_reset_tokens',
            'sessions',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Nommage des modèles
    |--------------------------------------------------------------------------
    */

    'naming' => [

        'language' => 'fr',

        /*
         * Correspondance explicite table logique -> classe modèle.
         * Ces correspondances sont prioritaires sur toute autre règle.
         *
         * Exemple :
         * 'utilisateurs' => 'User',
         */
        'models' => [
        ],

        /*
         * Exceptions de singularisation réutilisables mot par mot.
         *
         * Exemples :
         * 'chevaux' => 'cheval',
         * 'travaux' => 'travail',
         */
        'singular' => [
        ],

        /*
         * Mots à conserver strictement tels quels.
         * Peut notamment servir à lever une ambiguïté de vocabulaire.
         *
         * Exemple :
         * 'prix',
         */
        'invariable' => [
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Modèles
    |--------------------------------------------------------------------------
    */

    'models' => [
        'path' => app_path('Models'),
        'namespace' => 'App\\Models',

        'base_model' => true,
        'base_path' => app_path('Models/Base'),
        'base_namespace' => 'App\\Models\\Base',
        'base_suffix' => 'Base',
    ],

    /*
    |--------------------------------------------------------------------------
    | Migrations
    |--------------------------------------------------------------------------
    */

    'migrations' => [
        'path' => database_path('migrations'),
    ],
];
