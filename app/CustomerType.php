<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerType extends Model
{
    use SoftDeletes;

    protected $table = 'customer_types';

    protected $guarded = ['id'];
}
