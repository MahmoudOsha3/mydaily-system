<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [ 'name' , 'parent_id' ] ;


    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

        public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

    public function isDescendantOf(int $ancestorId): bool
    {
        $parentId = $this->parent_id;
        $visited = [];

        while ($parentId) {
            if ($parentId == $ancestorId) return true;

            if (isset($visited[$parentId])) return false;
            $visited[$parentId] = true;

            $parentId = Category::where('id', $parentId)
                ->value('parent_id');
        }

        return false;
    }
}
