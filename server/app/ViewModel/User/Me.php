<?php

namespace App\ViewModel\User;

use App\Models\User;
use Ramsey\Uuid\Type\Integer;

class Me
{

    public int $id;
    public string $name;
    public string $username;
    public string $email;

    // public function __construct(Integer $id, string $name, string $username, string $email)
    // {
    //     $this->id = $id;
    //     $this->name = $name;
    //     $this->username = $username;
    //     $this->email = $email;
    // }

    public function __construct()
    {
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    function getName()
    {
        return $this->name;
    }

    function setName($name)
    {
        $this->name = $name;
    }

    function getUsername()
    {
        return $this->username;
    }

    function setUsername($username)
    {
        $this->username = $username;
    }

    function getEmail()
    {
        return $this->email;
    }

    function setEmail($email)
    {
        $this->email = $email;
    }

    function convert(User $user)
    {
        $this->id = $user->id;
        $this->name = $user->name;
        $this->username = $user->username;
        $this->email = $user->email;
    }
}
