<?php
session_start();
class controller_edit extends Controller
{
    function __construct()
    {
        $this->model = new model_user();
        $this->view= new View();
        $this->access_lvl='user';
    }

    function action_index()
    {
        $link_header=$_GET['link_id_for_red'];
        $this->model->logout();
        $this->access();
        if (isset($_POST['edit_it']))
        {
            $this->model->update_link($link_header);
            if ($_SESSION['role']='editor')
            {
                exit(header('Location: http://first-test-project.lib/'));
            }
            exit(header('Location: http://first-test-project.lib/mylinks'));
        }
            $data=$this->model->link_load('linkSTORAGE',['link_header'=>$link_header]);
            foreach ($data as $k => $v)
            {
                foreach ($v as $x => $y) {
                    $c[$x]=$y;//array "select_from_where" from 0 to ... of selected rows
                }
            }
            $data=$c;

        $this->view->generate('edit_view.php', $data);

    }
}
(New controller_edit)->action_index();

