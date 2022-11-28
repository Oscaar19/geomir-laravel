<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visibility extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    public $guard_name = 'web';

    protected $fillable = [
        'public',
        'contacts',
        'private',
    ];

    public function places(){
        return $this->hasMany(Place::class);
    }
}
