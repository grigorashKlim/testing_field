<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Cache-Control" content="no-cache">

    <title>Главная</title>
    <!--BOOTSTRAP-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-------------->
    <link rel="stylesheet" href="/public/css/style.css">
</head>
<body >
<div class="row">


    <div class="col-6">

        <a  class="nav_option" href="info">Info</a>

        <a  class="nav_option" href="mylinks">My Links</a>

        <a  class="nav_option" href="/?profile_id=<?php print_r($_SESSION['user_login']);?>">My Profile</a>

        <a  class="nav_option" href="userList">User List</a>

    </div>


    <div class="  offset-4">
        Логин: <?php

        if (isset($_SESSION['user_login']))
        {
            echo $_SESSION['user_login'];
        }
        else
        {
            echo "Вы не авторизировались!";
        }

        ?>
        <form action="" method="post">
            <input type="submit" name="logout" value="Выйти">
        </form>
    </div>
</div>




    <?php
        $contetnt=VIEW_PATH.$content_view;
        if (!is_file($contetnt))
        {
            include ADM_VIEW_PATH.$content_view;
        }
        else
        {
            include VIEW_PATH.$content_view;
        }

    ?>


<!--BOOTSTRAP-->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<!-------------->


</body>
</html>
