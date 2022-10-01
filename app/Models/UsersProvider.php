<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersProvider extends Model
{
    use HasFactory;

    protected $table    = 'users';

    protected $guarded  = [];
    
}
