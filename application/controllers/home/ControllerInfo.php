<?php
session_start();

class ControllerInfo extends Controller
{
    function __construct()
    {
        $this->model = new ModelUser();
        $this->view = new View();
        $this->listing = new Listing();
        $this->linking = new Links();
    }

    function action()
    {
        $role=(New User)->getRole();

        if ($role && ($role == 'editor' || $role == 'admin')) {
            $this->access_lvl = 'editor';

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

            extract($pag_and_data = $this->listing->list_load('linkSTORAGE', null, 5));
            $this->view->generate('mylinks_view.php', $data, $pag_array);
        } else {
            if (isset($_POST['create'])) {
                $this->redirection('mylinks');
            }
            extract($pag_and_data = $this->listing->list_load('linkSTORAGE', ['privacy' => 'public'], 10));
            $this->view->generate('info_view.php', $data, $pag_array);
        }
    }
}

(New ControllerInfo)->action();


