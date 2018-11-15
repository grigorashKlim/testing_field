<?php
class model_user extends Model
{
    public function logout()
    {
        if (isset($_POST['logout']))
        {
            if (isset($_SESSION['user_login']))
            {
                unset($_SESSION['user_login']);
                unset($_SESSION['role']);
                session_destroy();
                exit(header('Location: http://first-test-project.lib/info'));
            }
        }
    }

    public function force_logout()
    {
            if (isset($_SESSION['user_login']))
            {
                unset($_SESSION['user_login']);
                unset($_SESSION['role']);
                session_destroy();
            }
    }

    public function link_creation()
    {
        $user_login=$_SESSION['user_login'];
        $privacy = "public";
        $link_header=$_POST['link_header'];
        $link=$_POST['link'];
        $description=$_POST['description'];
        if (isset($_POST['private'])) {
            $privacy = "private";
        }
        //create db for links
        $this->connectDB();
        $this->createDB('linkSTORAGE','link_header VARCHAR(500) NOT NULL,
            link VARCHAR(500) NOT NULL,
            creator VARCHAR(500) NOT NULL,
            privacy VARCHAR(500) NOT NULL,
		    reg_date TIMESTAMP');
        //link uniqueness check
        $header_from_db=$this->select_from_whereDB('link_header','linkSTORAGE',['link_header'=>$link_header]);
        if ($header_from_db!=null)
        {$header_from_db=$this->fetch_to_string($header_from_db);}
        $link_from_db=$this->select_from_whereDB('link','linkSTORAGE',['link'=>$link]);
        if ($link_from_db!=null)
        {$link_from_db=$this->fetch_to_string($link_from_db);}
        if ($link_header==$header_from_db && $link==$link_from_db)
        {
            echo " <br> Такая ссылка уже существует! <br>";
            return false;
        }
        $this->insertDB('linkSTORAGE', ['link_header'=>$link_header,
            'link'=>$link,
            'creator'=>$user_login,
            'privacy'=>$privacy]);
        $this->createDB('linkDESCRIPTION','link_header VARCHAR(500) NOT NULL,
            description VARCHAR(1000) NOT NULL');
        $this->insertDB('linkDESCRIPTION', ['link_header'=>$link_header,
            'description'=>$description]);
    }

    function links_display($table_name,$condition=null,$limit=null,$offset=null)
    {
        $column_names = $this->get_column_names($table_name,['id','creator']);
        $column_names=$this->fetch_to_array($column_names);
        $vlist='';
        foreach ($column_names as $k=>$v)
        {
            $vlist.=  $v . ',';
        }
        $vlist=rtrim($vlist,',');
        $row_array=$this->select_from_whereDB($vlist,$table_name,$condition,$limit,$offset);
        return $row_array;
    }

    /*function paginator($data,$limit)
    {
        $array_count=count($data );
        $array_count=ceil($array_count/$limit);
        if (isset($_GET['page']))
        {
            do {$offset=($_GET['page']-1)*$limit;}
            while (($_GET['page']-1)*$limit<$array_count);
        }
    }*/

    function description_display()
    {
        $link_header=$_GET['link_id'];

        $description=$this->select_from_whereDB('description','linkDESCRIPTION',['link_header'=>$link_header]);
        $description=$this->fetch_to_string($description);

        $creator=$this->select_from_whereDB('creator','linkSTORAGE',['link_header'=>$link_header]);
        $creator=$this->fetch_to_string($creator);

        $array=array($link_header,$description,$creator);
        return $array;
    }

    function update_link($link_header)
    {

        $link_header_typed=$_POST['link_header'];
        $link=$_POST['link'];
        $privacy=$_POST['privacy'];

        $link_header_db=$this->select_from_whereDB('link_header','linkSTORAGE',['link_header'=>$link_header]);
        $link_header_db=$this->fetch_to_string($link_header_db);
        if ($link_header_typed!=$link_header_db)
        {
            $this->updateDB('linkSTORAGE',['link_header'=>$link_header_typed],['link_header'=>$link_header_db]);
            $this->updateDB('linkDESCRIPTION',['link_header'=>$link_header_typed],['link_header'=>$link_header_db]);
        }

        $link_db=$this->select_from_whereDB('link','linkSTORAGE',['link_header'=>$link_header]);
        $link_db=$this->fetch_to_string($link_db);
        if ($link!=$link_db)
        {
            $this->updateDB('linkSTORAGE',['link'=>$link],['link_header'=>$link_header_db]);
        }

        $privacy_db=$this->select_from_whereDB('privacy','linkSTORAGE',['link_header'=>$link_header]);
        $privacy_db=$this->fetch_to_string($privacy_db);
        if ($privacy!=$privacy_db)
        {
            $this->updateDB('linkSTORAGE',['privacy'=>$privacy],['link_header'=>$link_header_db]);
        }
    }

    function delete_link($link_header)
    {
        $this->deleteDB('linkSTORAGE',['link_header'=>$link_header]);
        $this->deleteDB('linkDESCRIPTION',['link_header'=>$link_header]);
    }

    function get_profile_data($user_login)
    {
        if ($user_login==null)
        {
            $user_login=$_SESSION['user_login'];
        }
        $column_names = $this->get_column_names('MyGuests',['id','reg_date']);
        $column_names=$this->fetch_to_array($column_names);
        $vlist='';
        foreach ($column_names as $k=>$v)
        {
            $vlist.=  $v . ',';
        }
        $vlist=rtrim($vlist,',');
        $row_array=$this->select_from_whereDB($vlist,'MyGuests',['login'=>$user_login]);
        if (!is_array($row_array)){return false;}
        foreach ($row_array as $k => $v)
        {
            foreach ($v as $x => $y) {
                $c[$x]=$y;//array "select_from_where" from 0 to ... of selected rows
            }
        }
        $row_array=$c;
        return $row_array;
    }

    function change_profile($user_login=null)
    {
        if ($user_login==null)
        {
            $user_login=$_SESSION['user_login'];
        }

        $login_typed=$_POST['login'];
        $password_typed=$_POST['password'];
        $email_typed=$_POST['email'];

        $login_db=$this->select_from_whereDB('login','MyGuests',['login'=>$user_login]);
        $login_db=$this->fetch_to_string($login_db);
        $password_db=$this->select_from_whereDB('password','MyGuests',['login'=>$user_login]);
        $password_db=$this->fetch_to_string($password_db);
        $email_db=$this->select_from_whereDB('email','MyGuests',['login'=>$user_login]);
        $email_db=$this->fetch_to_string($email_db);
        if ($login_typed!=$login_db || $password_typed!=$password_db || $email_typed!=$email_db)
        {



            if ($password_typed != $password_db)
            {
                $this->updateDB('MyGuests', ['password'=>$password_typed], ['login' => $login_db]);
            }

            if ($email_typed != $email_db)
            {
                $this->updateDB('MyGuests', ['email'=>$email_typed], ['login' => $login_db]);
            }
            if ($login_typed != $login_db)
            {
                $checking_login=$this->select_from_whereDB('login','MyGuests',['login'=>$login_typed]);
                $checking_login=$this->fetch_to_string($checking_login);
                if( $checking_login !=$login_typed)
                {
                    $this->updateDB('MyGuests', ['login' => $login_typed], ['login' => $login_db]);
                    return $login_typed;
                }
                else
                {
                    echo "That username already exists! Please try another one!";
                    return false;
                }
            }
            else
            {
                return $user_login;
            }

        }
    }

    function relog($login)
    {

        $login_db=$this->select_from_whereDB('login','MyGuests',['login'=>$login]);
        $login_db=$this->fetch_to_string($login_db);
        $password_db=$this->select_from_whereDB('password','MyGuests',['login'=>$login]);
        $password_db=$this->fetch_to_string($password_db);
        $this->force_logout();
        $sign_in=new model_base();
        $sign_in->sign_in($login_db,$password_db);
    }
}