<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'task_template_id', 'title', 'description', 'date',
        'start_time', 'end_time', 'status', 'points', 'completed_at',
    ];

    protected $casts = [
        'date' => 'date',
        'completed_at' => 'datetime',
    ];

    public function template()
    {
        return $this->belongsTo(TaskTemplate::class, 'task_template_id');
    }

    public function scopeForDate($query, $date)
    {
        return $query->whereDate('date', $date);
    }

    public function scopeDone($query)
    {
        return $query->where('status', 'done');
    }

    public function markDone(): void
    {
        $this->update([
            'status' => 'done',
            'completed_at' => now(),
        ]);
    }

    public function markPending(): void
    {
        $this->update([
            'status' => 'pending',
            'completed_at' => null,
        ]);
    }

    public function markSkipped(): void
    {
        $this->update([
            'status' => 'skipped',
            'completed_at' => null,
        ]);
    }
}
