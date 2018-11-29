<?php

class model_base extends Model
{
    function __construct()
    {
        parent::__construct();

        if (isset($_POST['email']) && isset($_POST['repassword'])) {
            $this->email = $_POST['email'];
            $this->repassword = $_POST['repassword'];
        }
        if (isset($_POST['login']) && isset($_POST['password'])) {
            $this->login = $_POST['login'];
            $this->password = $_POST['password'];
        }


    }

    public function mail_post($email = null)
    {
        if ($email != null) {
            $this->email = $email;
        }
        $this->createDB('validate_temp', 'email VARCHAR(30) NOT NULL,
            checkSum VARCHAR(500) NOT NULL,
		    reg_date TIMESTAMP');
        $email_cnx = explode("@", $this->email);
        $checkSum = base64_encode(substr($this->login, 0, 3) . $email_cnx[0] . md5($_SERVER['REMOTE_ADDR']));
        $this->insertDB('validate_temp', ['email' => $this->email, 'checkSum' => $checkSum]);
        //Сообщение зарегистрированному пользователю
        $message = "
			Ссылка для активации:<a
			href='activate.php?checkSum=" . $checkSum . "&email=" . $this->email . "'>Перейти</a>;
			dvdfvd

			-----------------------------";
        @mail($this->email, "Активация аккаунта", $message, "Content-Type: text/html; 
			charset=windows-1251", "From: robot@mail.com");
    }

    public function Register()
    {
        $this->createDB('MyGuests', 'login VARCHAR(30) NOT NULL,
                password VARCHAR(30) NOT NULL,
                email VARCHAR(50) NOT NULL,
                status VARCHAR(50) NOT NULL,
                role VARCHAR(500) NOT NULL,
                reg_date TIMESTAMP');

        $status = "blocked";
        $role = "user";

        $checking_login = $this->select_from_whereDB('login', 'MyGuests', ['login' => $this->login]);
        /*print_r($chk);*/
        $this->login = trim($this->login);
        $this->email = trim($this->email);
        $this->password = trim($this->password);
        if ($checking_login != $this->login) {
            $ins = $this->insertDB('MyGuests', ['login' => $this->login,
                'password' => $this->password,
                'email' => $this->email,
                'status' => $status,
                'role' => $role]);
            if ($ins != null) {
                $this->mail_post();
                return true;
            } else {
                echo "Failed to insert data information!";

            }
        } else {
            echo "That username already exists! Please try another one!";
        }

    }

    public function mail_check()
    {
        $time = gmdate('Y-m-d h:i:s', time());
        $htime = substr($time, 11, -6);
        $u_checkSum = $_GET['checkSum'];
        $u_email = $_GET['email'];
        $checkSumDB = $this->select_from_whereDB('checkSum', 'validate_temp', ['email' => $u_email]);

        $checkSumDB = $this->fetch_to_string($checkSumDB);

        if ($checkSumDB == null) {
            return false;
        }

        //time check
        $timeDB = $this->select_from_whereDB('reg_date', 'validate_temp', ['email' => $u_email]);
        $timeDB = $this->fetch_to_string($timeDB);

        $htimeDB = substr($timeDB, 11, -6);
        $timedif = $htimeDB - $htime;
        if ($timedif != 0) {
            echo "Время жизни письма истекло!";
            return false;
        }
        //
        if ($checkSumDB == $u_checkSum) {
            $this->updateDB('MyGuests', ['status' => 'active'], ['email' => $u_email]);
            $this->deleteDB('validate_temp', ['email' => $u_email]);
        } else {
            echo "oops";
        }
    }

    public function sign_in($login, $password)
    {
        $error = ' ';
        echo "$error";
        //login fom DB
        $login_db = $this->select_from_whereDB('login', 'MyGuests', ['login' => $login]);
        $login_db = $this->fetch_to_string($login_db);

        //password from DB
        $password_db = $this->select_from_whereDB('password', 'MyGuests', ['login' => $login]);
        $password_db = $this->fetch_to_string($password_db);

        //user status
        $status_db = $this->select_from_whereDB('status', 'MyGuests', ['login' => $login]);
        $status_db = $this->fetch_to_string($status_db);


        if ($login == $login_db) {
            if ($password == $password_db) {
                if ($status_db == 'active') {
                    session_start();
                    $_SESSION['user_login'] = $login;
                    $role = $this->select_from_whereDB('role', 'MyGuests', ['login' => $login]);
                    $role = $this->fetch_to_string($role);
                    $_SESSION['role'] = $role;
                    print_r($role);
                    return $login;
                } else {
                    $error .= "Вы не подтвердили регистрацию!";
                    echo "$error";
                    echo "<br><a href=''>послать письмо еще раз</a><br>";
                }
            } else {
                $error .= "Неверный пароль!!";
                echo "$error";
            }
        } else {
            $error .= "Такого пользователя не существует!";
            echo "$error";
        }

    }
}