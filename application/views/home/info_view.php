
<div class="row ">
    <div class=" col-3">
    <?php
    if (isset($_SESSION['user_login']))
    {?>
        <a href="mylinks"><input type='submit' name='create'  value='Создать ссылку'></a>
        <?php
    }
    ?>
    </div>
    <div class="col-6">
        <div class="row ">
            <div class="col-3">
                <h3>Заголовок:</h3> <br>
                <?php /*echo "$data['link_header']"*/?>
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

            <?php

            $link_array=[];
            $link_id=0;
            if (is_array($data)) {
                foreach ($data as $index => $row) {
                    $link_id = $row['link_header'];
                    echo "<a name='$link_id' href='/?link_id=$link_id'><div class='row'>";
                    foreach ($row as $cell => $val) {
                        echo "<div class='col-3'>$val</div>";

                    }
                    echo "</div></a>";
                }
            }
            ?>
        <!--//pager//////-->
        <?php

        if (isset($_GET['page'])) {
            $current_page = $_GET['page'];
            $next = $current_page + 1;
            $prev = $current_page - 1;
            if ($current_page == 1) {
                $prev = $current_page;
            }
            if ($current_page = $array_count) {
                $next = $current_page;
            }
        } else {
            $prev = 1;
            $next = 2;
        }
       /* if ($limit!=null)
        {*/
            echo "<ul class='pagination'>
            <li class='page-item'>
                <a class='page-link' href='info?page=$prev' aria-label='Previous'>
                    <span aria-hidden='true'>&laquo;</span>
                    <span class='sr-only'>Previous</span>
                </a>
            </li>";
            for ($i = 1; $i <= $array_count; $i++) {
                echo "<li class='page-item'><a class='page-link' href='info?page=$i'>$i</a></li>";
            }
            echo "<li class='page-item'>
                <a class='page-link' href='info?page=$next' aria-label='Next'>
                    <span aria-hidden='true'>&raquo;</span>
                    <span class='sr-only'>Next</span>
                </a>
            </li>
        </ul>";/*}*/
        ?>
        <!--//pager//////-->
    </div>

</div>
