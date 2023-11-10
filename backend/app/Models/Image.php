<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'url',
    ];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
}
