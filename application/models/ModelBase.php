<?php

class ModelBase extends Model
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

    /**
     * @param null $email
     * create storage for checksums and emails for verification proccess.
     * Also sends email message for user with checksum
     */
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

    /**
     * @return bool
     * creates user table, checks login originality and insert data into DB with "blocked" user status.
     */
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

    /**
     * @return bool
     * checksums compare (local and user's) and lifetime
     */
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

            return false;
        }
        //
        if ($checkSumDB == $u_checkSum) {
            $this->updateDB('MyGuests', ['status' => 'active'], ['email' => $u_email]);
            $this->deleteDB('validate_temp', ['email' => $u_email]);
        } else {
            return false;
        }
    }

    /**
     * @param $login
     * @param $password
     * @return string
     * login,password,status check and putting login into session
     */
    public function sign_in($login, $password)
    {
        $login= trim($login, " \n.");
        $password= trim($password, " \n.");
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


        if ($login !== $login_db) {
            $error .= "Такого пользователя не существует!";
            $_SESSION['errors']=$error;
            return false;
        }

            if ($password == $password_db) {
                $error .= "Не верный пароль";
            }
                if ($status_db == 'active') {

                    $_SESSION['user_login'] = $login;
                    setcookie("SessionId", session_id());
                    return $login;
                }
                else {
                    $error .= "Вы не подтвердили регистрацию!";
                    $_SESSION['errors']=$error;
                    return false;
                }



    }
}