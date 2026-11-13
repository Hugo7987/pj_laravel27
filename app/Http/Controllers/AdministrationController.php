<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;

class AdministrationController extends Controller
{
    public function index(): View
    {
        Gate::authorize('administration.view');

        return view('administration');
    }
}
