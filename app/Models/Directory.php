<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Directory extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'parent',
    ];

    public function parent_directory()
    {
        return $this->belongsTo(Directory::class, 'parent', 'id');
    }

    public function children()
    {
        return $this->hasMany(Directory::class, 'parent', 'id');
    }
}
