<link rel="stylesheet" href="/public/css/popup_style.css">
<div class="row ">
    <div class=" col-3">
        <h2>Список пользователей => </h2>
    </div>
    <div class="col-7">

        <div class="row ">

            <div class="col">
                <h3>Логин:</h3> <br>

            </div>
            <div class="col">
                <h3>Пароль:</h3>  <br>

            </div>
            <div class="col">
                <h3>Почта:</h3>  <br>

            </div>
            <div class="col">
                <h3>Статус:</h3>  <br>

            </div>
            <div class="col">
                <h3>Роль:</h3>  <br>

            </div>
            <div class="col">
                <h3>Дата регистрации:</h3> <br>

            </div>
        </div>

        <?php
        /**
         * user list output cycle data
         */
        $link_array = [];
        $link_id = 0;
        if (is_array($data)) {
            foreach ($data as $index => $row) {
                $link_id = $row['login'];
                echo "<div class='row'>";
                foreach ($row as $cell => $val) {
                    echo "<div class='col'> $val </div>";
                }
                echo "</div>
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
