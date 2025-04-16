<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $guarded = [];

    protected $casts = [
        'checklist_completion_status' => 'integer'
    ];
    protected $hidden =[
        'todo_item_id',
        'user_id',
        'created_at',
        'updated_at'
    ];

    protected $with = ['items'];

    public function items()
    {
        return $this->hasMany(TodoItem::class);
    }
}
