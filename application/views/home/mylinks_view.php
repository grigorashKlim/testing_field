<link rel="stylesheet" href="/public/css/popup_style.css">
<div class="row ">
    <div class=" col-3">
        <h3>Создание новой ссылки: </h3>
        <form action="" method="post" class="rf">
            Заголовок: <br> <input type="text" name="link_header" class="rfield"><br>
            Ссылка: <br> <input type="text" name="link" class="rfield"><br>
            Описание: <br> <textarea name="description" class="rfield"></textarea><br>
            Приватность: <br> <input type="checkbox" name="private"> Приватная <br>
            <br>
            <input type="submit" name="add_link" class="btn_submit disabled" value="Добавить">
            <div ><?php
                if (isset($this->errors))
                echo $this->errors;
                ?></div>
        </form>
    </div>
    <div class="col-7">
        <div class="row ">

            <div class="col-3">
                <h3>Заголовок:</h3> <br>

            </div>
            <div class="col-3">
                <h3>Ссылка:</h3>  <br>

            </div>
            <div class="col-3">
                <h3>Приватность:</h3>  <br>

            </div>
            <div class="col-2">
                <h3>Дата создания:</h3>  <br>

            </div>
            <div class="col-1">
                <br>

            </div>
        </div>

        <?php
        /**
         * list output cycle
         */

        $link_id = 0;
        if (is_array($data)) {
            foreach ($data as $index => $row) {
                $link_id = $row['link_header'];
                echo "<a name='$link_id' href='/links/$link_id'><div class='row'>";
                foreach ($row as $cell => $val) {
                    echo "<div class='col'> $val </div>";
                }
                echo "</div></a>
    <br>
    <form name='' class='formlinks' method='post' action=''>
        <input type='hidden' name='edit_id' value='$link_id'>  
        <input class=\"btn btn-primary\" type='submit' value='редактировать' name='edit'>
        
        
    </form>
    
         
        <input type='button' class=\"btn btn-primary\" data-toggle=\"modal\" data-target=\"#delPopup_$link_id\"  value='удалить' >
        <!--POPUP-->
        
            <div class=\"modal fade\" id=\"delPopup_$link_id\" tabindex='' role=\"dialog\" aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\">
                <div class=\"modal-dialog\" role=\"document\">
                    <div class=\"modal-content\">
                        <div class=\"modal-header\">
                            <h5 class=\"modal-title\" id=\"exampleModalLabel\">Вы уверены,что хотите удалить?</h5>
                            <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                                
                            </button>
                        </div>
                        <div class=\"modal-footer\">
                            <input type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\" value=\"Закрыть\">
                            <form class='formlinks' method='post' action=''>
                                <input type=\"submit\" class=\"btn btn-primary\"  name=\"delete\" value='Удалить'>
                                <input type='hidden' name='del_id' value='$link_id'>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
        <!--POPUP--> 
        
    

";

            }
        }
        ?>
        <!--//pager//////-->
        <?php
        if (isset($this->pager)) {
            echo $this->pager;
        }
        ?>

        <!--//pager//////-->
    </div>
</div>
<script type="text/javascript" src="/public/js/jquery-3.3.1.min.js"></script>
<script src="/public/js/highlighter_info.js"></script>