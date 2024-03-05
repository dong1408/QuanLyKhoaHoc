<?php

namespace App\Utilities;

class ResponseError
{ 
    
    public $httpStatus; // String : BAD_REQUEST
    public $httpStatusCode; // Integer : 400
    public $message; // String:  message

    public function __construct($httpStatus, $httpStatusCode, $message)
    {
        $this->httpStatus = $httpStatus;
        $this->httpStatusCode = $httpStatusCode;
        $this->message = $message;
    }

    function getHttpStatus()
    {
        return $this->httpStatus;
    }

    function setHttpStatus($httpStatus)
    {
        $this->httpStatus = $httpStatus;
    }

    function getHttpStatusCode()
    {
        return $this->httpStatusCode;
    }

    function setHttpStatusCode($httpStatusCode)
    {
        $this->httpStatusCode = $httpStatusCode;
    }

    function getMessage(){
        return $this->message;
    }

    function setMessage($message){
        $this->message = $message;
    }
}
