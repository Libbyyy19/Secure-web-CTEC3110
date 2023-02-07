<?php

namespace Telemetry;

class BcryptWrapper
{

    public function __construct(){ }

    public function __destruct() { }

    /**
     * @param $string_to_hash
     * @return false|string|null
     * turns the password into an encrypted password
     */
    public function createHashedPassword($string_to_hash)
    {
        $password_to_hash = $string_to_hash;
        $bcrypt_hashed_password = '';

        if(!empty($password_to_hash))
        {
            $options = array('cost' => BCRYPT_COST);
            $bcrypt_hashed_password = password_hash($password_to_hash, BCRYPT_ALGO, $options);
        }
        return $bcrypt_hashed_password;
    }

    /**
     * @param $string_to_check
     * @param $stored_user_password_hash
     * @return bool
     * checks the password against the stored password to authenticate you are the correct user
     */
    public function authenticatePassword($string_to_check, $stored_user_password_hash)
    {
        $user_authenticated = false;
        $current_user_password = $string_to_check;
        $stored_user_password_hash = $string_to_check;
        if(!empty($current_user_password) && !empty($stored_user_password_hash))
        {
            if(password_verify($current_user_password, $stored_user_password_hash))
            {
                $user_authenticated = true;
            }
        }
        return $user_authenticated;
    }
}