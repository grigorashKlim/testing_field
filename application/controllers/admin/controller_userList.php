<?php
session_start();

class controller_userList extends Controller
{
    function __construct()
    {
        $this->model = new model_admin();
        $this->view = new View();
        $this->listing = new Listing();
        $this->access_lvl = 'admin';
        $this->access();
    }

    function action()
    {
        /*$this->model->logout();*/

        if (isset($_POST['edit'])) {
            $link_id = $_POST['edit_id'];
            exit(header('Location: http://first-test-project.lib/?profile_id=' . $link_id));


        }
        if (isset($_POST['delete'])) {
            $login_id = $_POST['del_id'];
            $this->model->delete_user($login_id);
        }
        extract($pag_and_data = $this->listing->list_load('MyGuests', null, 5));
        $this->view->generate('userList_view.php', $data, $pag_array);

    }
}

(New controller_userList)->action();

