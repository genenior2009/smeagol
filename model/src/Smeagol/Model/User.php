<?php
namespace Smeagol\Model;
class User
{
    public $id;
    public $username;
    public $password;
    public $name;
    public $surname;
    public $email;
    public $active;
    public $last_login;
    public $modified;
    public $role_type;

    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->username     = (isset($data['username'])) ? $data['username'] : null;
        $this->password     = (isset($data['password'])) ? $data['password'] : null;
        $this->name     = (isset($data['name'])) ? $data['name'] : null;
        $this->surname     = (isset($data['surname'])) ? $data['surname'] : null;
        $this->email     = (isset($data['email'])) ? $data['email'] : null;
        $this->active     = (isset($data['active'])) ? $data['active'] : null;
        $this->last_login     = (isset($data['last_login'])) ? $data['last_login'] : null;
        $this->modified     = (isset($data['modified'])) ? $data['modified'] : null;    
        $this->role_type     = (isset($data['role_type'])) ? $data['role_type'] : null;

    }
}