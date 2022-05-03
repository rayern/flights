<?php

namespace App\Models;

class User{
    const TABLE = 'users';

    public  function register(){
        $isRegistered = true;
        $db = new \Storage\Database();
        $duplicateUsers = $db->table(self::TABLE)->select('*')->where('username',$this->username)->get();
        if(count($duplicateUsers) > 0){
            $message = "This username is taken. Try another";
            $isRegistered = false;
        }
        else{
            $db->table(self::TABLE)->insert([
                'firstName' => (string) $this->firstName,
                'lastName' => (string) $this->lastName,
                'email' => (string) $this->email,
                'username' => $this->username,
                'password' => md5(md5($this->password))
            ]);
            $message = "Registeration successful. Welcome to the club";
            $isRegistered = true;
        }
        return ['success' => $isRegistered, 'message' => $message];
    }

    public function login(){
        $db = new \Storage\Database();
        $users = $db->table(self::TABLE)->select('*')->where('username',$this->username)->where('password',md5(md5($this->password)))->get();
        return (count($users) > 0);
    }
}