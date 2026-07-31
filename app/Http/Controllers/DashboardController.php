<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Transaction;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $todayTasks = Task::forDate($today)->get();

        $startOfMonth = $today->copy()->startOfMonth();
        $monthTasks = Task::whereBetween('date', [$startOfMonth, $today])->get();

        $endOfMonth = $today->copy()->endOfMonth();
        $transactions = Transaction::whereBetween('date', [$startOfMonth, $endOfMonth])->get();

        return view('pages.dashboard', [
            'today' => $today,
            'todayPoints' => $todayTasks->where('status', 'done')->sum('points'),
            'todayMax' => $todayTasks->sum('points'),
            'monthPoints' => $monthTasks->where('status', 'done')->sum('points'),
            'monthMax' => $monthTasks->sum('points'),
            'balance' => $transactions->where('type', 'income')->sum('amount') - $transactions->where('type', 'expense')->sum('amount'),
            'totalIncome' => $transactions->where('type', 'income')->sum('amount'),
            'totalExpense' => $transactions->where('type', 'expense')->sum('amount'),
        ]);
    }
}
