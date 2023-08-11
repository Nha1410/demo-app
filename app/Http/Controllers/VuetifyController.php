<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class VuetifyController extends Controller
{
    public function slide(): InertiaResponse
    {
        return Inertia::render('Vuetify/Slide', [
        ]);
    }
}
