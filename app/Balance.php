<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    protected $table = 'payments';
    protected $fillable = 	[
						        'user_id',
						        'money_amount',
						        'transection_by'
						    ];
}
