<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BioSettings extends Model
{
    protected $guarded = [];

    public static function getSettings()
    {
        return static::first() ?? static::create([
            'description_1' => 'With over two decades of experience...',
            'description_2' => 'Their performances have graced...',
            'philosophy_quote' => 'Music is the universal language...',
        ]);
    }
}
