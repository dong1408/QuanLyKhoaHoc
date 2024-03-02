<?php

namespace App\ViewModel\Auth;

class AuthenVm
{

    public $accessToken;
    public $refreshToken;

    function __construct($accessToken, $refreshToken)
    {
        $this->accessToken = $accessToken;
        $this->refreshToken = $refreshToken;
    }

    function getAccsessToken()
    {
        return $this->accessToken;
    }

    function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    function getRefreshToken()
    {
        return $this->refreshToken;
    }

    function setRefreshToken($refreshToken)
    {
        $this->refreshToken;
    }
}
