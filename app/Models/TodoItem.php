<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TodoItem extends Model
{
    protected $guarded = [];

    protected $casts = [
        'item_completion_status' => 'integer'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'todo_id'
    ];
    public function todo()
    {
        return $this->belongsTo(Todo::class);
    }
}
