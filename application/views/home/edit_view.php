<div class="row ">
    <div class=" col-3">
    </div>
    <div class="col-6">
        <form action='' method='post'>
            <div class="row ">
                <div class="col">
                    <h3>Заголовок:</h3> <br>
                    <input type='text' name="link_header" class='form-control'
                           value='<?php print_r($data['link_header']); ?>'>
                </div>
                <div class="col">
                    <h3>Ссылка:</h3>  <br>
                    <input type='text' name="link" class='form-control' value='<?php print_r($data['link']); ?>'>
                </div>
                <div class="col">
                    <h3>Приватность:</h3>  <br>
                    <input type='text' name="privacy" class='form-control' value='<?php print_r($data['privacy']); ?>'>
                </div>
                <div class="col">
                    <h3>Создана:</h3>  <br>
                    <input type='text' class='form-control' value='<?php print_r($data['reg_date']); ?>' readonly>
                </div>
                <div class="col">
                    <h3>&nbsp;</h3>
                    <br>
                    <input type='submit' name='edit_it' value='подтвердить'>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="/public/js/jquery-3.3.1.min.js"></script>
<script src="/public/js/highlighter_info.js"></script>