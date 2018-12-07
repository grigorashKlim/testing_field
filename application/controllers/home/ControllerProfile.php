<?php

class ControllerProfile extends Controller
{
    function __construct()
    {
        $this->model = new ModelUser();
        $this->access_lvl = 'user';
        $this->access();
    }

    function action($profile_id = null)
    {

        $user_login = (New User)->getLogin();

        if ($profile_id) {
            if ($profile_id !== $user_login) {
                $this->access_lvl = 'admin';
                $this->access();
            }
        }

        if (isset($_POST['confirm_changes'])) {
            if ($this->access_lvl = 'admin') {
                (New ModelAdmin())->change_role_status($profile_id);
            }
            $login = $this->model->change_profile($profile_id);
            if ($login == false) {
                $body['errors'] = 'Пользователь с таким именем уже существует! Пожалуйста, выберите другое имя.';
            }
            if ($profile_id == $user_login) {
                $this->model->relog($login);
                $this->redirection('info');

            } else {
                $this->redirection('userList');
            }

        }
        $template = 'profile_view.php';
        $header['title'] = 'Мой Профиль';
        $body['data'] = $this->model->get_profile_data($profile_id);
        $page = New Page($template, $header, $body);
        $page->composition();
    }
}

