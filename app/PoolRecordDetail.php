<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PoolRecordDetail extends Model
{
    protected $table = 'pool_recording_detail';

    protected $guarded = ['id'];

    public $timestamps = false;

    protected $casts = [
        'entry_date' => 'datetime',
        'exit_date' => 'datetime'
    ];

    public function customerType()
    {
        return $this->belongsTo('App\CustomerType', 'customer_type_id');
    }
}
