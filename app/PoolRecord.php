<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PoolRecord extends Model
{
    protected $table = 'pool_records';

    protected $guarded = ['id'];

    protected $casts = [
        'day' => 'date'
    ];

    public function detail()
    {
        return $this->hasMany('App\PoolRecordDetail', 'pool_record_id');
    }
}
