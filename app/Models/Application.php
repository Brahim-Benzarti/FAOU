<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;
    protected $fillable = [
        'Time',
        'First_Name',
        'Last_Name',
        'Email',
        'Nationality',
        'Birthday',
        'Position',
        'First_Time',
        'CV',
        'Biography',
        'Motivation_Letter',
        'User_id',
        'Users_Access',
        'seen',
        'flag',
        'incomplete',
        'accepted',
        'rejected',
        'stars',
        'mailed',
        'intern',
        'interviewed'
    ];
}
