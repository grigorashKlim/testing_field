<?php
session_start();

class ControllerProfile extends Controller
{
    function __construct()
    {
        $this->model = new ModelUser();
        $this->view = new View();
        $this->access_lvl = 'user';
        $this->access();
    }

    function action()
    {

        $user_login=(New User)->getLogin();

        if (isset($_GET['profile_id'])) {
            $profile_id = $_GET['profile_id'];
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

            if ($profile_id == $user_login) {
                $this->model->relog($login);
                $this->redirection('info');

            } else {
                $this->redirection('userList');
            }

        }
        $this->view->generate('profile_view.php', $this->model->get_profile_data($profile_id));
    }
}

(New ControllerProfile)->action();