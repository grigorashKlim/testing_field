<?php

class ControllerMyLinks extends Controller
{
    function __construct()
    {
        $this->model = new ModelUser();
        $this->listing = new Listing();
        $this->linking = new Links();
        $this->access_lvl = 'user';
        $this->access();
    }

    function action($link_id = null)
    {

        if (isset($_POST['edit'])) {
            $link_id = $_POST['edit_id'];
            $this->redirection('/edit/' . $link_id);
        }
        if (isset($_POST['delete'])) {
            $link_id = $_POST['del_id'];
            $this->linking->delete_link($link_id);
        }
        if (isset($_POST['add_link'])) {
            $this->linking->link_create();
        }
        $user_login = (New User)->getLogin();
        $template = 'mylinks_view.php';
        $header['title'] = 'Мои ссылки';
        $body['data_for_render'] = $this->listing->list_load('linkSTORAGE', ['creator' => $user_login], 5);
        $page = New Page($template, $header, $body);
        $page->composition();

    }
}



