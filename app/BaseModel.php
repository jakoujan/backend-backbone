<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Hashids\Hashids;
use App\Constants\Constants;

class BaseModel extends Model {

    private $hashids;

    public function __construct() {
        $this->hashids = new Hashids(Constants::HASH_KEY);
    }
    
    protected function encode($value) {
        return $this->hashids->encode($value);
    }
    
    protected function decode($value) {
        return $this->hashids->decode($value);
    }
    
    public function getIdAttribute($id) {
        return $this->encode($id);
    }
    
    public function setIdAttribute($id) {
        $this->attributes['id'] = $this->decode($id);
    }

}
