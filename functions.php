<?php
 
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

function pagination($page, $page_total, $atributes){
    $db = new Requests;
    $conn = $db->connectDB(); 
    $url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $curr_file = substr($_SERVER ["SCRIPT_NAME"], 1);?>
    
    <div class="jobs-pagination-wrapper">
        <div class="nav-links">
        <?php 
             for ($i = 1; $i <= $page_total; $i++) {
                $url = $beggining = $_SERVER["PHP_SELF"]."?";
                if($i == $page){
                    foreach($atributes as $atribute){
                        if(isset($_GET[$atribute])){ 
                            $url = $url.$atribute."=".$_GET[$atribute]."&";
                        }
                    } ?>
                    <a class='page-numbers current' href="<?php echo $url;?>page=<?php echo $i;?>"><?php echo $i ?></a>
        <?php } else {
                    foreach($atributes as $atribute){
                        if(isset($_GET[$atribute])){ 
                            $url = $url.$atribute."=".$_GET[$atribute]."&";
                        }
                                ?>
            <?php   } ?>
                    <a class='page-numbers' href="<?php echo $url;?>page=<?php echo $i;?>"><?php echo $i ?></a>
            <?php }
            }
}
