<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeaturedCompositions extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'mp3',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    public function getRouteKeyName()
    {
        return 'id';
    }
}
