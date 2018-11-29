<?php
session_start();
if (isset($_SESSION['user_login'])) {
    unset($_SESSION['user_login']);
    unset($_SESSION['role']);
    session_destroy();
    exit(header('Location: http://first-test-project.lib/info'));
}
