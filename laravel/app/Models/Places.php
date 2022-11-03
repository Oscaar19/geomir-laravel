<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Places extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'file_id',
        'latitude',
        'longitude',
        'visibility_id',
        'author_id',
        
    ];
}
