<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Constants\Constants;
use Hashids\Hashids;
use \stdClass;

class Controller extends BaseController {

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;
    
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

    public static function arrayToObject($array) {

        $obj = new stdClass;
        foreach ($array as $k => $v) {
            if (strlen($k)) {
                if (is_array($v)) {
                    $obj->{$k} = Controller::arrayToObject($v); //RECURSION
                } else {
                    $obj->{$k} = $v;
                }
            }
        }
        return $obj;
    }

}
