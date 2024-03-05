<?php

namespace App\Utilities;

class ResponseSuccess
{

    public $message;
    public $data;

    public function __construct($message, $data)
    {
        $this->message = $message;
        $this->data = $data;
    }

    function getMessage()
    {
        return $this->message;
    }

    function setMessage($message)
    {
        $this->message = $message;
    }

    function getData()
    {
        return $this->data;
    }

    function setData($data)
    {
        $this->data = $data;
    }
}
