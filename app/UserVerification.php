<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserVerification extends Model
{
	protected $table = 'user_verification';
    protected $fillable = 	[
						        'email',
						        'verification_token'
						    ];
	//$timestamps = false;
	protected $primaryKey = 'verification_token';
}
