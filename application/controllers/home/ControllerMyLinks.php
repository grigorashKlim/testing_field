<?php
session_start();

class ControllerMyLinks extends Controller
{
    function __construct()
    {
        $this->model = new ModelUser();
        $this->view = new View();
        $this->listing = new Listing();
        $this->linking = new Links();
        $this->access_lvl = 'user';
        $this->access();
    }

    function action()
    {

        if (isset($_POST['edit'])) {
            $link_id = $_POST['edit_id'];
            $this->redirection('?link_id_for_red=' . $link_id);
        }
        if (isset($_POST['delete'])) {
            $link_id = $_POST['del_id'];
            $this->linking->delete_link($link_id);
        }
        if (isset($_POST['add_link'])) {
            $this->linking->link_create();
        }

        $user_login = (New User)->getLogin();


        extract($pag_and_data = $this->listing->list_load('linkSTORAGE', ['creator' => $user_login], 5));
        $this->view->generate('mylinks_view.php', $data, $pag_array);

    }
}

(New ControllerMyLinks)->action();

