<?php

namespace App\Admin\Views\components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Spatie\Permission\PermissionRegistrar;

class AppLayout extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('admin::layout.app-layout');
    }
}
