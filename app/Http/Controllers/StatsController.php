<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class StatsController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->query('month')
            ? Carbon::parse($request->query('month').'-01')
            : Carbon::now()->startOfMonth();

        $startOfMonth = $month->copy()->startOfMonth();
        $endOfMonth = $month->copy()->endOfMonth();

        $days = [];
        $cursor = $startOfMonth->copy();

        while ($cursor->lte($endOfMonth)) {
            $dayTasks = Task::forDate($cursor)->get();

            $days[] = [
                'date' => $cursor->toDateString(),
                'day' => $cursor->day,
                'points' => $dayTasks->where('status', 'done')->sum('points'),
                'max_points' => $dayTasks->sum('points'),
                'done_count' => $dayTasks->where('status', 'done')->count(),
                'total_count' => $dayTasks->count(),
            ];

            $cursor->addDay();
        }

        $totalPointsMonth = collect($days)->sum('points');
        $totalMaxMonth = collect($days)->sum('max_points');
        $bestDay = collect($days)->sortByDesc('points')->first();

        return view('pages.stats.index', [
            'month' => $month,
            'days' => $days,
            'totalPointsMonth' => $totalPointsMonth,
            'totalMaxMonth' => $totalMaxMonth,
            'bestDay' => $bestDay,
        ]);
    }
}
