<?php

namespace App\Company\Dashboard\Controllers;

use Domain\Company\Models\Company;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class DashboardController
{
    /**
     * @param Company|null $company
     *
     * @return Application|Factory|View
     */
    public function index(?Company $company = null): Factory|View|Application
    {
        return view('company::pages.dashboard');
    }
}
