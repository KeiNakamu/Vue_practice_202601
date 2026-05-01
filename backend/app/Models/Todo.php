<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
  protected $table = 'todos';
  protected $fillable = [
    'user_id',
    'content',
    'limit_date',
    'state',
    'created_process',
    'updated_process',
    ];
}
