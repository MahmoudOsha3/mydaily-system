<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TaskController extends Controller
{
    public function today(Request $request)
    {
        $date = $request->query('date')
            ? Carbon::parse($request->query('date'))
            : Carbon::today();

        $this->generateFromTemplates($date);

        $tasks = Task::forDate($date)
            ->orderByRaw('start_time IS NULL, start_time')
            ->orderBy('id')
            ->get();

        $totalPoints = $tasks->where('status', 'done')->sum('points');
        $maxPoints = $tasks->sum('points');

        return view('pages.tasks.today', [
            'date' => $date,
            'tasks' => $tasks,
            'totalPoints' => $totalPoints,
            'maxPoints' => $maxPoints,
        ]);
    }

    protected function generateFromTemplates(Carbon $date): void
    {
        $exists = Task::forDate($date)->whereNotNull('task_template_id')->exists();
        if ($exists) {
            return;
        }

        $templates = TaskTemplate::where('is_active', true)->orderBy('sort_order')->get();

        foreach ($templates as $template) {
            Task::firstOrCreate(
                [
                    'task_template_id' => $template->id,
                    'date' => $date->toDateString(),
                ],
                [
                    'title' => $template->title,
                    'start_time' => $template->start_time,
                    'end_time' => $template->end_time,
                    'points' => $template->points,
                    'status' => 'pending',
                ]
            );
        }
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'points' => 'nullable|integer|min:0',
        ]);

        Task::create([
            'task_template_id' => null,
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'date' => $data['date'],
            'start_time' => $data['start_time'] ?? null,
            'end_time' => $data['end_time'] ?? null,
            'points' => $data['points'] ?? 5,
            'status' => 'pending',
        ]);

        return back()->with('success', 'تم إضافة التاسك');
    }

    public function updateStatus(Request $request, Task $task)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,done,skipped',
        ]);

        match ($data['status']) {
            'done' => $task->markDone(),
            'skipped' => $task->markSkipped(),
            default => $task->markPending(),
        };

        return back()->with('success', 'تم تحديث حالة التاسك');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return back()->with('success', 'تم حذف التاسك');
    }
}
