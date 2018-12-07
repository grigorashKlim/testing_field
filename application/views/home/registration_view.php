<div class="wrapper">
    <h1>Регистрация</h1>
    <form action="" method="post" class="rf">
        Логин: <br> <input type="text" name="login" class="rfield"><br>
        Пароль: <br> <input type="password" name="password" id="password" class="rfield"><br>
        Подтвердите пароль: <br> <input type="password" name="repassword" id="repassword" class="rfield"><br>
        Почта: <br> <input type="text" name="email" id="email" class="rfield"><br><br>
        <input type="submit" name="register" class="btn_submit disabled" value="Зарегистрироваться"><br>
        <div id="error"></div>
        <div id="password_check"></div>
        <div id="email_check"></div>
        <input type="submit" name="reged" value="Войти"><br>
    </form>
</div>
<script type="text/javascript" src="/public/js/jquery-3.3.1.min.js"></script>
<script src="/public/js/highlighter.js"></script>