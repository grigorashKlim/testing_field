<?php

class model_admin extends model_user
{
    function delete_user($login_id)
    {
        $this->deleteDB('MyGuests', ['login' => $login_id]);
    }

    function change_role_status($profile_id)
    {
        $role_typed = $_POST['role'];
        $status_typed = $_POST['status'];

        $role_db = $this->select_from_whereDB('role', 'MyGuests', ['login' => $profile_id]);
        $role_db = $this->fetch_to_string($role_db);
        $status_db = $this->select_from_whereDB('status', 'MyGuests', ['login' => $profile_id]);
        $status_db = $this->fetch_to_string($status_db);
        $email_db = $this->select_from_whereDB('email', 'MyGuests', ['login' => $profile_id]);
        $email_db = $this->fetch_to_string($email_db);

        if ($role_typed != $role_db || $status_typed != $status_db) {
            if ($role_typed != $role_db) {
                $this->updateDB('MyGuests', ['role' => $role_typed], ['login' => $profile_id]);
            }
            if ($status_typed != $status_db) {
                $this->updateDB('MyGuests', ['status' => $status_typed], ['login' => $profile_id]);
                $this->deleteDB('validate_temp', ['email' => $email_db]);
            }
        }
    }
}
