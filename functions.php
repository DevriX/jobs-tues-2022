<?php
if (!isset ($_GET['page']) ) {  
    $page = 1;  
} else {  
    $page = $_GET['page'];  
}

function time_diff_mesage($diff){
    switch($diff){
        case 0:
            echo " today."; break;
        case 1:
            echo " yesterday."; break;
        default:
            echo $diff." days ago.";
    }
}

function validate($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;

}

function pagination($page, $page_total){
    if($page_total > 1){
        for ($i = 1; $i <= $page_total; $i++) {
            $_GET['page'] = $i;
            $current = "";
            if($i == $page){
                $current = "current";
            }
    ?>
            <a class='page-numbers <?php echo $current ?>'
            href="<?php echo $_SERVER["PHP_SELF"]."?".http_build_query($_GET);?>">
            <?php echo $i; ?></a>
    <?php
        }
    }
}
