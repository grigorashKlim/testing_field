<?php
session_start();

class controller_profile extends Controller
{
    function __construct()
    {
        $this->model = new model_user();
        $this->view = new View();
        $this->access_lvl = 'user';
        $this->access();
    }

    function action()
    {
        if (isset($_GET['profile_id'])) {
            $profile_id = $_GET['profile_id'];
            if ($profile_id != $_SESSION['user_login']) {
                $this->access_lvl = 'admin';
            }
        }

        /*$this->model->logout();*/
        if (isset($_POST['confirm_changes'])) {
            if ($this->access_lvl = 'admin') {
                (New model_admin())->change_role_status($profile_id);
            }
            $login = $this->model->change_profile($profile_id);
            $user_login = $_SESSION['user_login'];
            if ($profile_id == $user_login) {
                $this->model->relog($login);
                exit(header('Location: http://first-test-project.lib/info'));

            } else {
                exit(header('Location: http://first-test-project.lib/userList'));
            }

        }
        $this->view->generate('profile_view.php', $this->model->get_profile_data($profile_id));
    }
}

(New controller_profile)->action();