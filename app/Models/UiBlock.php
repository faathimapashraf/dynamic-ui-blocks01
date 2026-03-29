<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UiBlock extends Model
{
     protected $fillable = [
        'title',
        'type',
        'status',
        'display_order',
        'content'
    ];

    protected $casts = [
    'content' => 'array',
];
}
