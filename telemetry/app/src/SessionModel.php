<?php

namespace Telemetry;

class SessionModel
{
    private $username;
    private $password;
    private $storage_result;
    private $session_wrapper_file;



    public function __construct()
    {
        $this->username = null;
        $this->password = null;
        $this->storage_result = null;
        $this->session_wrapper_file = null;

    }

    public function __destruct() { }


    public function setSessionUsername($username)
    {
        $this->username = $username;
    }

    public function setSessionPassword($password)
    {
        $this->password = $password;
    }


    public function setSessionWrapperFile($session_wrapper)
    {
        $this->session_wrapper_file = $session_wrapper;
    }


    public function setSessionRole($role)
    {
        $this->role = $role;
    }

    public function storeData()
    {
        $store_result = false;

        $store_result_username = $this->session_wrapper_file->setSessionVar('username', $this->username);
        $store_result_password = $this->session_wrapper_file->setSessionVar('password', $this->password);
        $store_result_role = $this->session_wrapper_file->setSessionVar('role', $this->role);

        if($store_result_username !== false && $store_result_password !== false && $store_result_role !== false)
        {
            $store_result = true;
        }
        return $store_result;
    }





}