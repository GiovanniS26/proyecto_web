<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PagesController extends Controller
{
    /**
     * Retorna la vista del dashboard según el rol,
     * si es Admin podrá ver el dashboard de admin, sino
     * se le mostrará el dashboard de cliente
     */
    public function dashboard(): View 
    {
        if (auth()->user()->hasRole('admin')) {
            return view('app.admin_dashboard');
        }
    
        return view('app.user_dashboard');
    }
}
