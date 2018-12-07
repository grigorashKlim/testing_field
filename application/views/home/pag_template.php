<?php
/**
 * draw pager= buttons with page numbers and arrow buttons
 * $curr_page_name needs for navigation when  one content view used for different controllers
 */
if (isset($_GET['route'])) {
    $curr_page_name = $_GET['route'];
} else {
    $curr_page_name = 'index';
}
if (isset($pag_array))
{
    extract($pag_array);
}
if (isset($necessity) && $necessity != null) {
    //display
    echo "<ul class='pagination' >
            <li class='page-item'>
                <a class='page-link' href='$curr_page_name?page=$prev' aria-label='Previous'>
                    <span aria-hidden='true'>&laquo;</span>
                    <span class='sr-only'>Previous</span>
                </a>
            </li>";
    for ($i = 1; $i <= $storage_counter; $i++) {
        echo "<li class='page-item'><a class='page-link' href='$curr_page_name?page=$i'>$i</a></li>";
    }
    echo "<li class='page-item'>
                <a class='page-link' href='$curr_page_name?page=$next' aria-label='Next'>
                    <span aria-hidden='true'>&raquo;</span>
                    <span class='sr-only'>Next</span>
                </a>
            </li>
        </ul>";
}
?>
