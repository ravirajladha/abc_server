<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz_master extends Model
{
    use HasFactory;
    protected $table = 'quiz_masters';
    public $timestamps = false;
}
