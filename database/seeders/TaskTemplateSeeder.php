<?php

namespace Database\Seeders;

use App\Models\TaskTemplate;
use Illuminate\Database\Seeder;

class TaskTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            ['title' => 'الشغل', 'start_time' => '09:00', 'end_time' => '18:00', 'points' => 30, 'sort_order' => 1],
            ['title' => 'ممارسة لغة', 'start_time' => null, 'end_time' => null, 'points' => 10, 'sort_order' => 2],
            ['title' => 'مذاكرة', 'start_time' => null, 'end_time' => null, 'points' => 15, 'sort_order' => 3],
            ['title' => 'صلاة الفجر', 'start_time' => null, 'end_time' => null, 'points' => 5, 'sort_order' => 4],
            ['title' => 'صلاة الظهر', 'start_time' => null, 'end_time' => null, 'points' => 5, 'sort_order' => 5],
            ['title' => 'صلاة العصر', 'start_time' => null, 'end_time' => null, 'points' => 5, 'sort_order' => 6],
            ['title' => 'صلاة المغرب', 'start_time' => null, 'end_time' => null, 'points' => 5, 'sort_order' => 7],
            ['title' => 'صلاة العشاء', 'start_time' => null, 'end_time' => null, 'points' => 5, 'sort_order' => 8],
        ];

        foreach ($templates as $template) {
            TaskTemplate::updateOrCreate(['title' => $template['title']], $template);
        }
    }
}
