<?php

class controller_registration extends Controller
{
    function __construct()
    {
        $this->model = new model_base();
        $this->view = new View();

    }

    function action()
    {
        /*function nocache()
        {
          header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
          header("Last-Modified: " . gmdate("D, d M Y H:i:s")." GMT");
          header("Cache-Control: no-cache, must-revalidate");
          header("Cache-Control: post-check=0,pre-check=0", false);
          header("Cache-Control: max-age=0", false);
          header("Pragma: no-cache");
        }
        nocache();*/
        $this->view->generate('main_view.php');

        if (isset($_POST['register'])) {
            /*$this->model->connectDB();*/
            $a = $this->model->Register();
            if ($a == true) {
                exit(header('Location: http://first-test-project.lib/regfinish'));

            }
        }
        if (isset($_POST['reged'])) {
            exit(header('Location: http://first-test-project.lib/login'));
        }
    }
}

(New controller_registration)->action();

