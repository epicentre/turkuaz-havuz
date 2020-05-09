<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

class SpaController extends Controller
{
    /**
     * Get the SPA view.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        return view('spa');
    }
}
