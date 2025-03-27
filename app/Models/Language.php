<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'measurement'
    ];

    public function translations()
    {
        return $this->hasMany(Translation::class, 'lang', 'code');
    }

}
