<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = [
        'operation',
        'user_id',
        'currency_from',
        'value_from',
        'currency_to',
        'value_to',
        'created_at'
    ];
}
