<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Show the dashboard page.
     *
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Dashboard');
    }
}
