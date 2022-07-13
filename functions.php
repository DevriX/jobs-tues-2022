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


function pagination($page, $page_total){
    $atributes = ['search', 'drop_down_menu', 'job_id']; 
    for ($i = 1; $i <= $page_total; $i++) {
        $current = "";
        $url = $_SERVER["PHP_SELF"]."?";
        if($i == $page){
            $current = "current";
        }
        foreach($atributes as $atribute){
            if(isset($_GET[$atribute])){ 
                $url = $url.$atribute."=".$_GET[$atribute]."&";
            }
        }
?>
        <a class='page-numbers <?php echo $current ?>' href="<?php echo $url;?>page=<?php echo $i;?>"><?php echo $i ?></a>
<?php 
    }
}
