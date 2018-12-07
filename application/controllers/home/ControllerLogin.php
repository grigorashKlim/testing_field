<?php

class ControllerLogin extends Controller
{
    function __construct()
    {
        $this->model = new ModelBase();
    }

    function action()
    {
        $body = null;
        if (isset($_GET['checkSum']) && isset($_GET['email'])) {
            $result = $this->model->mail_check();
            if ($result == false) {
                $body['errors'] = 'Время жизни письма истекло!';
            }
        }
        if (isset($_POST['enter'])) {
            $this->login = $_POST['login'];
            $this->password = $_POST['password'];
            $user_login = $this->model->sign_in($this->login, $this->password);
            if ($user_login == false) {
                $body['errors'] = $_SESSION['errors'];
            }
            if ($user_login) {
                $this->redirection('info');
            }
        }
        $template = 'login_view.php';
        $header['title'] = 'Авторизация';
        $page = New Page($template, $header, $body);
        $page->composition();
    }
}



