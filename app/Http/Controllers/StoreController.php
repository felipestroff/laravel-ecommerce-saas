<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function dashboard()
    {
        return Inertia::render('Store/Dashboard');
    }
}
