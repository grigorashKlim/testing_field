<?php

class model_user extends Model
{


    public function force_logout()
    {
        if (isset($_SESSION['user_login'])) {
            unset($_SESSION['user_login']);
            unset($_SESSION['role']);
            session_destroy();
        }
    }


    function get_profile_data($user_login)
    {
        if ($user_login == null) {
            $user_login = $_SESSION['user_login'];
        }
        $column_names = $this->get_column_names('MyGuests', ['id', 'reg_date']);
        $column_names = $this->fetch_to_array($column_names);
        $vlist = '';
        foreach ($column_names as $k => $v) {
            $vlist .= $v . ',';
        }
        $vlist = rtrim($vlist, ',');
        $row_array = $this->select_from_whereDB($vlist, 'MyGuests', ['login' => $user_login]);
        if (!is_array($row_array)) {
            return false;
        }
        foreach ($row_array as $k => $v) {
            foreach ($v as $x => $y) {
                $c[$x] = $y;//array "select_from_where" from 0 to ... of selected rows
            }
        }
        $row_array = $c;
        return $row_array;
    }

    function change_profile($user_login = null)
    {
        if ($user_login == null) {
            $user_login = $_SESSION['user_login'];
        }

        $login_typed = $_POST['login'];
        $password_typed = $_POST['password'];
        $email_typed = $_POST['email'];

        $login_db = $this->select_from_whereDB('login', 'MyGuests', ['login' => $user_login]);
        $login_db = $this->fetch_to_string($login_db);
        $password_db = $this->select_from_whereDB('password', 'MyGuests', ['login' => $user_login]);
        $password_db = $this->fetch_to_string($password_db);
        $email_db = $this->select_from_whereDB('email', 'MyGuests', ['login' => $user_login]);
        $email_db = $this->fetch_to_string($email_db);
        if ($login_typed != $login_db || $password_typed != $password_db || $email_typed != $email_db) {
            if ($password_typed != $password_db) {
                $this->updateDB('MyGuests', ['password' => $password_typed], ['login' => $login_db]);
            }

            if ($email_typed != $email_db) {
                $this->updateDB('MyGuests', ['email' => $email_typed], ['login' => $login_db]);
            }
            if ($login_typed != $login_db) {
                $checking_login = $this->select_from_whereDB('login', 'MyGuests', ['login' => $login_typed]);
                $checking_login = $this->fetch_to_string($checking_login);
                if ($checking_login != $login_typed) {
                    $this->updateDB('MyGuests', ['login' => $login_typed], ['login' => $login_db]);
                    $this->updateDB('linkSTORAGE', ['creator' => $login_typed], ['creator' => $login_db]);
                    return $login_typed;
                } else {
                    echo "That username already exists! Please try another one!";
                    return false;
                }
            } else {
                return $user_login;
            }

        }
    }

    function relog($login)
    {

        $login_db = $this->select_from_whereDB('login', 'MyGuests', ['login' => $login]);
        $login_db = $this->fetch_to_string($login_db);
        $password_db = $this->select_from_whereDB('password', 'MyGuests', ['login' => $login]);
        $password_db = $this->fetch_to_string($password_db);
        $this->force_logout();
        $sign_in = new model_base();
        $sign_in->sign_in($login_db, $password_db);
    }
}