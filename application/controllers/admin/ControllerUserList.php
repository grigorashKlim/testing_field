<?php

class ControllerUserList extends Controller
{
    function __construct()
    {
        $this->model = new ModelAdmin();
        $this->listing = new Listing();
        $this->access_lvl = 'admin';
        $this->access();
    }

    function action()
    {
        if (isset($_POST['edit'])) {
            $link_id = $_POST['edit_id'];
            $this->redirection('/Profile/' . $link_id);
        }
        if (isset($_POST['delete'])) {
            $login_id = $_POST['del_id'];
            $this->model->delete_user($login_id);
        }
        $template = 'userList_view.php';
        $header['title'] = 'Список пользователей';
        $body['data_for_render'] = $this->listing->list_load('MyGuests', null, 5);
        $page = New Page($template, $header, $body);
        $page->composition();
    }
}



