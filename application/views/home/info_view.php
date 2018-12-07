<div class="row ">
    <div class=" col-3">
        <?php
        if ((New User)->getLogin() != 'unreg') {
            ?>
            <a href="my_links"><input type='submit' name='create' value='Создать ссылку'></a>
            <?php
        }
        ?>
    </div>
    <div class="col-6">
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
            <div class="col-3">
                <h3>Дата создания:</h3>  <br>

            </div>
        </div>
        <!--listing-->
        <?php
        /**
         * list output cycle data
         */
        $link_array = [];
        $link_id = 0;
        if (is_array($data)) {
            foreach ($data as $index => $row) {
                $link_id = $row['link_header'];
                echo "<a name='$link_id' href='/links/$link_id'><div class='row'>";
                foreach ($row as $cell => $val) {
                    echo "<div class='col-3'>$val</div>";

                }
                echo "</div></a>";
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
