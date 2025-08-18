<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role_id === 1) {
            $stats = [
                'total_users' => User::count(),
                'total_products' => Product::count(),
                'total_categories' => Category::count(),
            ];

            return view('dashboard', compact('stats'));
        }

        return view('dashboard');
    }
}
