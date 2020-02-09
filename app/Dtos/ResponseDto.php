<?php

namespace App\Dtos;

class ResponseDto
{
    public $status;
    public $message;
    public $code;
    public $fields = array();

    public function __construct()
    {
        $this->status = 0;
        $this->code = 200;
    }
}
