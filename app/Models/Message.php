<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'target', 'message', 'url', 'filename', 'schedule', 'typing', 'delay', 'countrycode', 'file', 'location', 'fllowup'
    ];
}
