<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class FinanceController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->query('month')
            ? Carbon::parse($request->query('month').'-01')
            : Carbon::now()->startOfMonth();

        $startOfMonth = $month->copy()->startOfMonth();
        $endOfMonth = $month->copy()->endOfMonth();

        $transactions = Transaction::whereBetween('date', [$startOfMonth, $endOfMonth])
            ->orderByDesc('date')
            ->orderByDesc('id')
            ->get();

        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;

        $expensesByCategory = $transactions->where('type', 'expense')
            ->groupBy(fn ($t) => $t->category ?: 'أخرى')
            ->map(fn ($group) => $group->sum('amount'))
            ->sortDesc();

        return view('pages.finance.index', [
            'month' => $month,
            'transactions' => $transactions,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'balance' => $balance,
            'expensesByCategory' => $expensesByCategory,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0.01',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'date' => 'required|date',
        ]);

        Transaction::create($data);

        return back()->with('success', 'تم تسجيل الحركة المالية');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return back()->with('success', 'تم حذف الحركة');
    }
}
