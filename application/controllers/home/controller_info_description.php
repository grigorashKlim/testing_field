<?php
session_start();
class controller_info_description extends Controller
{
    function __construct()
    {
        $this->model = new model_user();
        $this->view= new View();

    }

    function action_index()
    {
        $this->model->logout();
        if(!isset($_GET['link_id'])) {
            $data=null;
        }
        $data=$this->model->description_display();
        $this->view->generate('info_view_description.php', $data);

    }
}
(New controller_info_description)->action_index();

