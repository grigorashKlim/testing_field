<?php
session_start();
class controller_userList extends Controller
{
    function __construct()
    {
        $this->model = new model_admin();
        $this->view= new View();
        $this->access_lvl='admin';
    }

    function action_index()
    {
        $this->model->logout();
        $this->access();
        if (isset($_POST['edit']))
        {
            $link_id=$_POST['edit_id'];
            exit(header('Location: http://first-test-project.lib/?profile_id='.$link_id));


        }
        if (isset($_POST['delete']))
        {
            $login_id=$_POST['del_id'];
            $this->model->delete_user($login_id);
        }
        //paginator
        $array_count=count($this->model->link_load('MyGuests'));
        $limit=5;
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
        $data=$this->model->link_load('MyGuests',null,$limit,$offset);
        $this->view->generate('userList_view.php',$data,['array_count'=>$array_count,'limit'=>$limit]);

    }
}
(New controller_userList)->action_index();

