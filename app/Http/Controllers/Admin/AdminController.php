<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LibraryPdf;
use App\Models\Message;
use App\Models\Order;
use App\Models\Product;
use App\Models\TestResult;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'users'    => User::count(),
            'tests'    => TestResult::count(),
            'pdfs'     => LibraryPdf::count(),
            'products' => Product::count(),
            'messages' => Message::count(),
            'orders'   => Order::count(),
        ];

        $latestUsers    = User::latest()->take(5)->get();
        $latestTests    = TestResult::with('user')->latest()->take(5)->get();
        $recentMessages = Message::latest()->take(5)->get();

        // Monthly chart data (last 6 months)
        $chartMonths = collect(range(5, 0))->map(fn($i) => now()->subMonths($i)->format('M'));
        $usersChart  = collect(range(5, 0))->map(fn($i) =>
            User::whereMonth('created_at', now()->subMonths($i)->month)
                ->whereYear('created_at', now()->subMonths($i)->year)->count()
        );
        $testsChart  = collect(range(5, 0))->map(fn($i) =>
            TestResult::whereMonth('created_at', now()->subMonths($i)->month)
                ->whereYear('created_at', now()->subMonths($i)->year)->count()
        );

        $unreadMessages = Message::where('status', 'unread')->count();
        $pendingOrders  = Order::where('status', 'pending')->count();

        return view('admin.dashboard', compact(
            'stats', 'latestUsers', 'latestTests', 'recentMessages',
            'chartMonths', 'usersChart', 'testsChart',
            'unreadMessages', 'pendingOrders'
        ));
    }
}
