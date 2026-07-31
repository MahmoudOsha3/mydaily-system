<?php

namespace App\Http\Controllers;

use App\Models\TaskTemplate;
use Illuminate\Http\Request;

class TaskTemplateController extends Controller
{
    public function index()
    {
        $templates = TaskTemplate::orderBy('sort_order')->get();

        return view('pages.tasks.templates', compact('templates'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'points' => 'required|integer|min:0',
            'sort_order' => 'nullable|integer',
        ]);

        TaskTemplate::create($data);

        return back()->with('success', 'تم إضافة التاسك الثابت');
    }

    public function update(Request $request, TaskTemplate $template)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'points' => 'required|integer|min:0',
            'sort_order' => 'nullable|integer',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        $template->update($data);

        return back()->with('success', 'تم تعديل التاسك الثابت');
    }

    public function destroy(TaskTemplate $template)
    {
        $template->delete();

        return back()->with('success', 'تم حذف التاسك الثابت');
    }
}
