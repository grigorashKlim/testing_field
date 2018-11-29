<?php
session_start();

class controller_edit extends Controller
{
    function __construct()
    {
        $this->model = new model_user();
        $this->view = new View();
        $this->listing = new Listing();
        $this->linking = new Links();
        $this->access_lvl = 'user';
        $this->access();
    }

    function action()
    {
        $link_header = $_GET['link_id_for_red'];
        /*$this->model->logout();*/

        if (isset($_POST['edit_it'])) {
            $this->linking->update_link($link_header);
            if ($_SESSION['role'] = 'editor') {
                exit(header('Location: http://first-test-project.lib/'));
            }
            exit(header('Location: http://first-test-project.lib/mylinks'));
        }
        extract($pag_and_data = $this->listing->list_load('linkSTORAGE', ['link_header' => $link_header]));

        //prepare data array to display in view
        foreach ($data as $key => $value) {
            foreach ($value as $column_name => $column_value) {
                $intermediate_array[$column_name] = $column_value;//array "select_from_where" from 0 to ... of selected rows
            }
        }
        $data = $intermediate_array;

        $this->view->generate('edit_view.php', $data, $pag_array);

    }
}

(New controller_edit)->action();

