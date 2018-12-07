<?php

class ControllerInfo extends Controller
{
    function __construct()
    {
        $this->model = new ModelUser();
        $this->listing = new Listing();
        $this->linking = new Links();
    }

    function action()
    {
        $role = (New User)->getRole();
        $header['title'] = 'Главная';
        if ($role && ($role == 'editor' || $role == 'admin')) {
            $this->access_lvl = 'editor';

            if (isset($_POST['edit'])) {
                $link_id = $_POST['edit_id'];
                $this->redirection('/edit/' . $link_id);
            }
            if (isset($_POST['delete'])) {
                $link_id = $_POST['del_id'];
                $this->linking->delete_link($link_id);
            }
            if (isset($_POST['add_link'])) {
                $result = $this->linking->link_create();
            }
            $template = 'mylinks_view.php';
            if (isset($result) && $result == false) {
                $body['errors'] = 'Такая ссылка уже существует!';
            }

            $body['data_for_render'] = $this->listing->list_load('linkSTORAGE', null, 5);
        } else {
            if (isset($_POST['create'])) {
                $this->redirection('mylinks');
            }
            $template = 'info_view.php';
            $body['data_for_render'] = $this->listing->list_load('linkSTORAGE', ['privacy' => 'public'], 10);
        }
        $page = New Page($template, $header, $body);
        $page->composition();
    }
}




