<?php
/**
 * Class Listing
 * contains methods to work with displaying lists on pages
 */

class Listing
{
    public function __construct()
    {
        $this->model = new Model;
    }

    /**
     * @param $table_name
     * @param $condition
     * @param $limit
     * @return mixed
     * prepare data for paginator:
     * logic for next, previous buttons,amount of page buttons and necessity of paginator at all.
     */
    function pagination_buttons_data($table_name, $condition, $limit)
    {
        $necessity = null;
        $storage_counter = $this->model->arrayCount($table_name, $condition);
        if ($storage_counter > $limit) {
            $necessity = 1;
        }
        if ($limit != null) {
            $storage_counter = ceil($storage_counter / $limit);
        }
        if (isset($_GET['page'])) {
            $current_page = $_GET['page'];
            $next = $current_page + 1;
            $prev = $current_page - 1;
            if ($current_page == 1) {
                $prev = $current_page;
            }
            if ($current_page + 1 > $storage_counter) {
                $next = $current_page;
            }
            unset($current_page);
        } else {
            $prev = 1;
            $next = 2;
        }
        $pag_array['necessity'] = $necessity;
        $pag_array['next'] = $next;
        $pag_array['prev'] = $prev;
        $pag_array['storage_counter'] = $storage_counter;
        return $pag_array;
    }

    /**
     * @param $table_name
     * @param null $condition
     * @param null $limit
     * @return mixed
     * prepare rows data for displaying on a view page
     * takes where and with such parameters(condition,offset and limit if set) to take data from table
     * returns array with 2 arrays in it: first with info for paginating, other with data itself.
     */
    function list_load($table_name, $condition = null, $limit = null)
    {
        $column_names = $this->model->get_column_names($table_name, ['id', 'creator']);
        $column_names = $this->model->fetch_to_array($column_names);
        $vlist = '';
        foreach ($column_names as $k => $v) {
            $vlist .= $v . ',';
        }
        $vlist = rtrim($vlist, ',');

        if (isset($_GET['page'])) {
            $offset = ($_GET['page'] - 1) * $limit;
        } else {
            $offset = 0;
        }
        $data = $this->model->select_from_whereDB($vlist, $table_name, $condition, $limit, $offset);
        $pag_array = $this->pagination_buttons_data($table_name, $condition, $limit);
        $pag_and_data['pag_array'] = $pag_array;
        $pag_and_data['data'] = $data;
        return $pag_and_data;
    }

}