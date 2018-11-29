<?php

class Links
{
    public function __construct()
    {
        $this->model = new Model;
    }

    public function link_create()
    {
        $user_login = $_SESSION['user_login'];
        $privacy = "public";
        $link_header = $_POST['link_header'];
        $link = $_POST['link'];
        $description = $_POST['description'];
        if (isset($_POST['private'])) {
            $privacy = "private";
        }
        //create db for links
        $this->model->createDB('linkSTORAGE', 'link_header VARCHAR(500) NOT NULL,
            link VARCHAR(500) NOT NULL,
            creator VARCHAR(500) NOT NULL,
            privacy VARCHAR(500) NOT NULL,
		    reg_date TIMESTAMP');
        //link uniqueness check
        $header_from_db = $this->model->select_from_whereDB('link_header', 'linkSTORAGE', ['link_header' => $link_header]);
        if ($header_from_db != null) {
            $header_from_db = $this->model->fetch_to_string($header_from_db);
        }
        $link_from_db = $this->model->select_from_whereDB('link', 'linkSTORAGE', ['link' => $link]);
        if ($link_from_db != null) {
            $link_from_db = $this->model->fetch_to_string($link_from_db);
        }
        if ($link_header == $header_from_db && $link == $link_from_db) {
            echo " <br> Такая ссылка уже существует! <br>";
            return false;
        }
        $this->model->insertDB('linkSTORAGE', ['link_header' => $link_header,
            'link' => $link,
            'creator' => $user_login,
            'privacy' => $privacy]);
        $this->model->createDB('linkDESCRIPTION', 'link_header VARCHAR(500) NOT NULL,
            description VARCHAR(1000) NOT NULL');
        $this->model->insertDB('linkDESCRIPTION', ['link_header' => $link_header,
            'description' => $description]);
    }

    function link_description()
    {
        $link_header = $_GET['link_id'];

        $description = $this->model->select_from_whereDB('description', 'linkDESCRIPTION', ['link_header' => $link_header]);
        $description = $this->model->fetch_to_string($description);

        $creator = $this->model->select_from_whereDB('creator', 'linkSTORAGE', ['link_header' => $link_header]);
        $creator = $this->model->fetch_to_string($creator);

        $array = array($link_header, $description, $creator);
        return $array;
    }

    function update_link($link_header)
    {

        $link_header_typed = $_POST['link_header'];
        $link = $_POST['link'];
        $privacy = $_POST['privacy'];

        $link_header_db = $this->model->select_from_whereDB('link_header', 'linkSTORAGE', ['link_header' => $link_header]);
        $link_header_db = $this->model->fetch_to_string($link_header_db);
        if ($link_header_typed != $link_header_db) {
            $this->model->updateDB('linkSTORAGE', ['link_header' => $link_header_typed], ['link_header' => $link_header_db]);
            $this->model->updateDB('linkDESCRIPTION', ['link_header' => $link_header_typed], ['link_header' => $link_header_db]);
        }

        $link_db = $this->model->select_from_whereDB('link', 'linkSTORAGE', ['link_header' => $link_header]);
        $link_db = $this->model->fetch_to_string($link_db);
        if ($link != $link_db) {
            $this->model->updateDB('linkSTORAGE', ['link' => $link], ['link_header' => $link_header_db]);
        }

        $privacy_db = $this->model->select_from_whereDB('privacy', 'linkSTORAGE', ['link_header' => $link_header]);
        $privacy_db = $this->model->fetch_to_string($privacy_db);
        if ($privacy != $privacy_db) {
            $this->model->updateDB('linkSTORAGE', ['privacy' => $privacy], ['link_header' => $link_header_db]);
        }
    }

    function delete_link($link_header)
    {
        $this->model->deleteDB('linkSTORAGE', ['link_header' => $link_header]);
        $this->model->deleteDB('linkDESCRIPTION', ['link_header' => $link_header]);
    }
}