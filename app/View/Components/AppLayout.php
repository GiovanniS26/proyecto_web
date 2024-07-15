<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    /**
     * Layout para la vista de la app
     */
    public function render(): View
    {
        return view('layouts.app');
    }
}
