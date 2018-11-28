<?php
session_start();
class controller_mylinks extends Controller
{
    function __construct()
    {
        $this->model = new model_user();
        $this->view= new View();
        $this->access_lvl='user';
    }

    function action_index()
    {
        $this->model->logout();
        $this->access();

        if (isset($_POST['edit']))
        {
            $link_id=$_POST['edit_id'];
            exit(header('Location: http://first-test-project.lib/?link_id_for_red='.$link_id));
        }
        if (isset($_POST['delete']))
        {
            $link_id=$_POST['del_id'];
            $this->model->delete_link($link_id);
        }
        if (isset($_POST['add_link']))
        {
            $this->model->link_create();
        }

        $user_login=$_SESSION['user_login'];

        //paginator
        $limit=5;
        $array_count=count($this->model->link_load('linkSTORAGE',['creator'=>$user_login]));

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

        $data=$this->model->link_load('linkSTORAGE',['creator'=>$user_login],$limit,$offset);
        $this->view->generate('mylinks_view.php',$data ,['array_count'=>$array_count,'limit'=>$limit]);

    }
}
(New controller_mylinks)->action_index();

