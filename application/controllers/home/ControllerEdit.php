<?php

class ControllerEdit extends Controller
{
    function __construct()
    {
        $this->model = new ModelUser();
        $this->listing = new Listing();
        $this->linking = new Links();
        $this->access_lvl = 'user';
        $this->access();
    }

    function action($link_header = null)
    {

        if (isset($_POST['edit_it'])) {
            $this->linking->update_link($link_header);
            if ($_SESSION['role'] = 'editor') {
                $this->redirection(' ');
            }
            $this->redirection('my_links');
        }
        extract($pag_and_data = $this->listing->list_load('linkSTORAGE', ['link_header' => $link_header]));

        //prepare data array to display in view
        foreach ($data as $key => $value) {
            foreach ($value as $column_name => $column_value) {
                $intermediate_array[$column_name] = $column_value;//array "select_from_where" from 0 to ... of selected rows
            }
        }
        $data = $intermediate_array;
        $template = 'edit_view.php';
        $header['title'] = 'Редактирование';
        $body['data'] = $data;
        $page = New Page($template, $header, $body);
        $page->composition();

    }
}



