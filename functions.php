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


function pagination($sql_request, $num_rows_request){
    $db = new Requests;
    $conn = $db->connectDB(); 

    $limit = 5;

    if (!isset ($_GET['page']) ) {  
        $page = 1;  
    } else {  
        $page = $_GET['page'];  
    }

    $page_first_result = ($page-1) * $limit;
    $num_rows = mysqli_num_rows ($conn->query($num_rows_request));
    $page_total = ceil($num_rows / $limit);

    ?> <ul class="jobs-listing"> <?php

    $request_job_info = $conn->query($sql_request." LIMIT $page_first_result, $limit");

    while($row = mysqli_fetch_array($request_job_info, MYSQLI_BOTH)) {
        $company_image_path = "/uploads/company_images/".$row["company_image"];?>
        <li class="job-card">
            <div class="job-primary">
                <h2 class="job-title"><a href="#"><?php echo $row["title"];?></a></h2>
                <div class="job-meta">
                    <a class="meta-company" href="#"><?php echo $row["company_name"];?></a>
                    <span class="meta-date">Posted <?php echo time_diff_mesage($row["date"]);?></span>
                </div>
                <div class="job-details">
                    <span class="job-location"><?php echo $row["location"];?></span>
                    <span class="job-type">Contract staff</span>
                </div>
            </div>
            <div class="job-logo">
                <div class="job-logo-box">
                    <img src=<?php echo $company_image_path;?> alt="">
                </div>
            </div>
        </li>
    <?php  } ?>
    </ul>
    <div class="jobs-pagination-wrapper">
        <div class="nav-links">
        <?php 
            for ($i = 1; $i <= $page_total; $i++) {
                $url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

                    if($i == $page){
                        if(strpos($url, "search")){
                            if(isset($_GET['search'])){
                                printf("<a class='page-numbers current' %shref='index.php?search=%s&page=%u'>%u</a>", 
                                $i==$page ? : "",$_GET['search'], $i, $i);
                            }
                        } else{
                            printf("<a class='page-numbers current' %shref='index.php?page=%u'>%u</a>", 
                                $i==$page ? : "", $i, $i );
                        }
                    }
                    else{
                        if(strpos($url, "search")){
                            if(isset($_GET['search'])){
                                printf("<a class='page-numbers' %shref='index.php?search=%s&page=%u'>%u</a>", 
                                $i==$page ? : "",$_GET['search'], $i, $i );
                            }
                        } else{
                            printf("<a class='page-numbers' %shref='index.php?page=%u'>%u</a>", 
                                $i==$page ? : "", $i, $i );
                        }
                    }
            }?>
        </div>
    </div>
<?php } ?>