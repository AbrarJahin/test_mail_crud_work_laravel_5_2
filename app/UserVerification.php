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
	//$timestamps = false;		//Disabling timestamps
	protected $primaryKey = 'verification_token';
	public $incrementing = false;	//for using non integer as a PK
}
