<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Hashids\Hashids;
use App\Constants\Constants;

class User extends Authenticatable {

    protected $table = 'tbl_transactional_users';
    protected $primaryKey = 'id';
    private $hashids;

    public function __construct() {
        $this->hashids = new Hashids(Constants::HASH_KEY);
    }

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer', 'name', 'user', 'email', 'password', 'modules'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'customer', 'password', 'remember_token', 'api_token', 'email_verified_at', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'modules' => 'json'
    ];

    public function getIdAttribute($id) {
        return $this->hashids->encode($id);
    }

    public function setIdAttribute($id) {
        $this->attributes['id'] = $this->hashids->decode($id);
    }

}
