<?php
session_start();

class controller_info_description extends Controller
{
    function __construct()
    {
        $this->model = new model_user();
        $this->view = new View();
        $this->listing = new Listing();
        $this->linking = new Links();
    }

    function action()
    {
        /*$this->model->logout();*/
        if (!isset($_GET['link_id'])) {
            $data = null;
        }
        $data = $this->linking->link_description();
        $this->view->generate('info_view_description.php', $data);

    }
}

(New controller_info_description)->action();

