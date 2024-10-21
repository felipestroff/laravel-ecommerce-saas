<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    public function dashboard()
    {
        $categoryCount = Category::where('user_id', Auth::id())->count();
        return Inertia::render('Store/Dashboard', ['categoryCount' => $categoryCount]);
    }
}
