<?php
if (!isset ($_GET['page']) ) {  
    $page = 1;  
} else {  
    $page = $_GET['page'];  
}

$page_first_result = ($page-1) * RES_LIMIT;

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

function url_path_http(){
    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'){
        $url = "https://";
    } else{
        $url = "http://";
    }

    $url.= $_SERVER['HTTP_HOST'];
    
    return $url;
}

function change_url_parameter($url,$parameterName,$parameterValue) {
    $url=parse_url($url);
    parse_str($url["query"],$parameters);
    unset($parameters[$parameterName]);
    $parameters[$parameterName]=$parameterValue;
    return  sprintf("%s://%s%s?%s", 
        $url["scheme"],
        $url["host"],
        $url["path"],
        http_build_query($parameters));
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

function filter(){
    return "SELECT j.title, j.location, DATEDIFF(CURDATE(), j.date_posted) AS 'date', u.company_name, u.company_image 
            FROM jobs as j 
            JOIN jobs_categories AS jc ON j.id=jc.job_id 
            JOIN users as u on u.id = j.user_id 
            WHERE j.title LIKE '%teacher%' AND jc.category_id = 5 
            ORDER BY date_posted DESC";
}