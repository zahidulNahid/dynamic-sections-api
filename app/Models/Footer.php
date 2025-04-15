<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Footer extends Model
{
    use HasFactory;
    protected $fillable = [
        'color',
        'logo',
        'login_link',
        'app_store_link',
        'google_play_link',
        'first_text',
        'second_text',
        'third_text',
    ];

}
