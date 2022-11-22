<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'latitude',
        'longitude',
        'file_id',
        'category_id',
        'visibility_id',
        'author_id'

    ];
    public function file()
    {
        return $this->belongsTo(File::class);
    }

    public function user()
    {
        // foreign key does not follow conventions!!!
        return $this->belongsTo(User::class, 'author_id');
    }
    public function author()
    {
        return $this->belongsTo(User::class);
    }
    public function favorited()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

}


