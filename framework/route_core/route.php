<?php 
class Router {
public $route;
public $controller;
    function separate()
    {
        $this->route = (empty($_GET['route'])) ? '' : $_GET['route'];
          if(isset($_GET['checkSum'])&&isset($_GET['email']))
        {
            $this->route='activate';
        }

        if(isset($_GET['link_id']))
        {
            $link_id=$_GET['link_id'];
            $this->route='info+'.$link_id;
            return $link_id;
        }

        if(isset($_GET['link_id_for_red']))
        {
            $link_id_for_red=$_GET['link_id_for_red'];
            $this->route='edit+'.$link_id_for_red;
            return $link_id_for_red;
        }
        if(isset($_GET['profile_id']))
        {
            $profile_id=$_GET['profile_id'];
            $this->route='edit+'.$profile_id;

        }

        if (empty($this->route))
        {
            $this->route='index';
        }
    }

    function compare()
    {
        $link_id=self::separate();
        $link_id_for_red=self::separate();

        $table=new Registry;
        $table->set ('accessDenied','accessDenied');
        $table->set ('registration','registration');
        $table->set ('index','info');
        $table->set ('info','info');
        if(isset($_GET['profile_id']))
        {
            $profile_id=$_GET['profile_id'];
            $this->route='profile+'.$profile_id;
            $table->set ('profile+'.$profile_id,'profile');
        }
        $table->set ('info+'.$link_id,'info_description');
        $table->set ('edit+'.$link_id_for_red,'edit');
        $table->set ('admin','admin'); 
        $table->set ('activate','login');
        $table->set ('login','login');
        $table->set ('regfinish','regfinish');
        $table->set ('mylinks','mylinks');
        $table->set ('userList','userList');
        $arg=$table->get($this->route);
        if ($arg=='regfinish'){$this->controller= CONT_PATH.'regfinish.php';return true;}
        if ($arg=='accessDenied'){$this->controller= CONT_PATH.'accessDenied.php';return true;}


            $this->controller= CONT_PATH.'controller_'.$arg.'.php';
        if (!is_file($this->controller))
        {
            $this->controller= ADM_CONT_PATH.'controller_'.$arg.'.php';
            if (!is_file($this->controller))
            {
                $this->controller = CONT_PATH . '404.php';
            }
        }



    }
    
    function init()
    {
        self::compare();
        include $this->controller;
    }

}


