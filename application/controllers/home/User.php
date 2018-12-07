<?php
/*session_start();*/
/**
 * contains user data such as login and password
*/
class User
{
    public $role;
    public $status;
    public $login;

    /**
     * @return string
     * get login from session after signing in.
     * if null login = "unreg"
     */
    public function getLogin()
    {
        if (isset($_SESSION['user_login'])){
            $this->login=$_SESSION['user_login'];
            return $this->login;
        }
        else{
            return 'unreg';
        }
    }

    /**
     * @return array|bool|mixed
     * returns role of user
     */
    public function getRole()
    {
        $login=$this->getLogin();
        if ($login=='unreg')
        {
            return 'unreg';
        }
        $this->role = (New Model)->select_from_whereDB('role', 'MyGuests', ['login' => $login]);
        $this->role = (New Model)->fetch_to_string($this->role);
        return $this->role;
    }

}