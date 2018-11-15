<div class="row ">
    <div class=" col-3">
    </div>
    <div class="col-7">
        <form action="" method="post" class="rf">
            Логин: <br> <input type="text" name="login" class="rfield" value='<?php print_r($data['login']);?>'>
            <br>
            Пароль: <br> <input type="text" name="password" id="password" class="rfield" value='<?php echo $data['password'];?>'>
            <br>
            Подтвердите пароль: <br> <input type="text" name="repassword" id="repassword" class="rfield" value='<?php print_r($data['password']);?>'>
            <br>
            Почта: <br> <input type="text" name="email" id="email" class="rfield " value='<?php print_r($data['email']);?>'>
            <?php
                if ($_SESSION['role']=='admin')
                {
                    $display='';
                }
                else
                {
                    $display='none';
                }
            ?>
            <span style="display: <?php print_r($display);?>;">
                <br>
            Роль: <br> <input  type="text" name="role"  class="rfield " value='<?php print_r($data['role']);?>'>
            <br>
            Статус: <br> <input type="text" name="status"  class="rfield " value='<?php print_r($data['status']);?>'>
                </span>
            <br><br>
            <input type="submit" name="confirm_changes" class="btn_submit disabled" value="Подтвердить изменения" ><br>
            <div id="error"></div>
            <div id="password_check"></div>
            <div id="email_check"></div>
        </form>
    </div>

    </div>
</div>
<script type="text/javascript" src="/public/js/jquery-3.3.1.min.js"></script>
<script src="/public/js/highlighter.js"></script>