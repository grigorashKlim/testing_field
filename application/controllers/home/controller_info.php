<?php
session_start();
class controller_info extends Controller
{
    function __construct()
    {
        $this->model = new model_user();
        $this->view= new View();
    }

    function action_index()
    {
        /*$this->model->connectDB();*/

        if (isset($_POST['logout']))
        {
            if (isset($_SESSION['user_login']))
            {
                $this->model->logout();
            }
        }

        //paginator
        $limit=5;
        $array_count=count($this->model->link_load('linkSTORAGE'));

        if ($array_count<$limit)
        {
            $limit=null;
            $offset=null;
        }

        if ($limit!=null){$array_count=ceil($array_count/$limit);}
            if (isset($_GET['page']))
            {
                $offset = ($_GET['page'] - 1) * $limit;
            }
            else
            {
                $offset=0;
            }
        //

        if ((isset($_SESSION['role'])) && ($_SESSION['role'] == 'editor' || $_SESSION['role'] == 'admin'))
        {
            $this->access_lvl = 'editor';

            if (isset($_POST['edit']))
            {
                $link_id = $_POST['edit_id'];
                exit(header('Location: http://first-test-project.lib/?link_id_for_red=' . $link_id));
            }

            if (isset($_POST['delete']))
            {
                $link_id = $_POST['del_id'];
                $this->model->delete_link($link_id);
            }

            if (isset($_POST['add_link']))
            {
                $this->model->link_create();
            }
            $data=$this->model->link_load('linkSTORAGE',null,$limit,$offset);
            $this->view->generate('mylinks_view.php',$data,['array_count'=>$array_count,'limit'=>$limit]);
        }

        else
        {
            if (isset($_POST['create']))
            {
                exit(header('Location: http://first-test-project.lib/mylinks'));
            }
            $data=$this->model->link_load('linkSTORAGE',['privacy' => 'public'],$limit,$offset);
            $this->view->generate('info_view.php',$data,['array_count'=>$array_count,'limit'=>$limit]);
        }
    }
}
(New controller_info)->action_index();


