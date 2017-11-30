<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    const ACTIVE = 1;
    const COMPLETED = 2;
    const REMOVED = 3;
    
    protected $table = 'todos';
}
