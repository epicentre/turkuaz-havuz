<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PoolRecord extends Model
{
    protected $table = 'pool_records';

    public $timestamps = false;

    protected $casts = [
        'entry_date' => 'datetime',
        'exit_date' => 'datetime'
    ];
}
