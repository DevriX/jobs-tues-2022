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

function homepage_job_listing($request_job_info){
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
    <?php  } 
}

function job_dashboard_listing($request_job_info){ 
    while($row = mysqli_fetch_array($request_job_info, MYSQLI_BOTH)) { ?>
        <li class="job-card">
                            <div class="job-primary">
                                <h2 class="job-title"><a href="submissions.php?job_id=<?php echo $row['main_id']; ?>"><?php echo $row["title"]; ?></a></h2>
                                <div class="job-meta">
                                    <a class="meta-company" href="#"><?php echo $row["company_name"]; ?></a>
                                    <span class="meta-date">Posted <?php echo $row["date"]; ?> days ago</span>
                                </div>
                                <div class="job-details">
                                    <span class="job-location"><?php echo $row["location"]; ?></span>
                                    <span class="job-type">Contract staff</span>
                                </div>
                            </div>
                            <div class="job-secondary">
                                <div class="job-actions">
                                    <form method="post">
                                        <?php if($row['status'] == 0){ ?>
											<a href="<?php echo $_SERVER["PHP_SELF"]?>?search=<?php echo $search; ?>&drop_down_menu=<?php echo $order; ?>&job_id=<?php echo $row['main_id']; ?>&status=a"> Approve </a>
										<?php } else { ?>
											<a href="<?php echo $_SERVER["PHP_SELF"]?>?search=<?php echo $search; ?>&drop_down_menu=<?php echo $order; ?>&job_id=<?php echo $row['main_id']; ?>&status=r">Reject</a>
										<?php } ?>
                                    </form>
                                </div>
                                <div class="job-edit">
                                    <a href="submissions.php?job_id=<?php echo $row['main_id']; ?>">View Submissions</a>
                                    <a href="actions-job.php?edit_job=<?php echo $row['main_id']?>">Edit</a>
                                </div>
                            </div>
                        </li>
    <?php  } 
}

function display_submissions($request_info, $title_check){
    while($row = mysqli_fetch_array($request_info, MYSQLI_BOTH)) { ?>
    <div class="section-heading">
        <?php if(!$title_check){?>
            <h2 class="heading-title"><?php echo $row["title"];?> - Submissions - <?php echo mysqli_num_rows( $request_info); ?> Appliciants</h2>
        <?php $title_check=1; }?>	
    </div>
    <ul class="jobs-listing">
            <li class="job-card">
                <div class="job-primary">
                    <h2 class="job-title"><?php echo "" . $row["first_name"] . " " . $row["last_name"] . "";?></h2>
                </div>
                <div class="job-secondary centered-content">
                    <div class="job-actions">
                        <a href="view-submission.php?user_id=<?php echo $row['user_id']; ?>" class="button button-inline">View</a>
                    </div>
                </div>
            </li>
<?php  }
}

function display_category_dashboard($request_info){
    while($row = mysqli_fetch_array($request_info, MYSQLI_BOTH)) { ?>
        <li class="job-card">
                    <div class="job-primary">
                        <h2 class="job-title"><?php echo $row["title"]?></h2>
                    </div>
                    <div class="job-secondary centered-content">
                        <div class="job-actions">
                            <a href="<?php echo $_SERVER["PHP_SELF"]?>?cat_id=<?php echo $row['id']; ?>" class="button button-inline">Delete</a>
                        </div>
                    </div>
                </li>
<?php  }
}

function pagination($sql_request){
    $db = new Requests;
    $conn = $db->connectDB(); 
    $url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $curr_file = substr($_SERVER ["SCRIPT_NAME"], 1);
    $limit = 5;

    if (!isset ($_GET['page']) ) {  
        $page = 1;  
    } else {  
        $page = $_GET['page'];  
    }

    $page_first_result = ($page-1) * $limit;
    $num_rows = mysqli_num_rows ($conn->query($sql_request));
    $page_total = ceil($num_rows / $limit);

    ?> <ul class="jobs-listing"> <?php

    $request_info = $conn->query($sql_request." LIMIT $page_first_result, $limit");

    if (strpos($url, "category-dashboard")){
        display_category_dashboard($request_info);
    }else if(strpos($url, "dashboard")){
        if(mysqli_num_rows($request_info) > 0){
            job_dashboard_listing($request_info);
        }
    } else if (strpos($url, "submissions")){
        $title_check = 0;
        if(mysqli_num_rows($request_info) > 0){
            display_submissions($request_info, $title_check);
        } else { 
            $request_job_title = $conn->query(
                "SELECT jobs.title FROM jobs WHERE jobs.id=" . $_GET['job_id'] ."");
            $job_row = mysqli_fetch_array($request_job_title, MYSQLI_BOTH) ?>
            <h2 class="heading-title"><?php echo $job_row['title'];?> - Submissions - 0 Appliciants</h2>
        <?php }
    } else{
        homepage_job_listing($request_info);
    }
    
    ?> </ul>
    <div class="jobs-pagination-wrapper">
        <div class="nav-links">
        <?php 
             for ($i = 1; $i <= $page_total; $i++) {
                $url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

                    if($i == $page){
                        if(strpos($url, "search")){
                            if(isset($_GET['search'])){
                                if(isset($_GET['drop_down_menu'])){
                                    printf("<a class='page-numbers current' %shref='%s?drop_down_menu=%u&search=%s&page=%u'>%u</a>", 
                                    $i==$page ? : "",$curr_file, $_GET['drop_down_menu'], $_GET['search'], $i, $i);
                                }else{
                                    printf("<a class='page-numbers current' %shref='%s?search=%s&page=%u'>%u</a>", 
                                    $i==$page ? : "", $curr_file, $_GET['drop_down_menu'], $i, $i);
                                }
                            }
                        } else{
                            if(isset($_GET['drop_down_menu'])){
                                printf("<a class='page-numbers current' %shref='%s?drop_down_menu=%u&page=%u'>%u</a>", 
                                    $i==$page ? : "", $curr_file, $_GET['drop_down_menu'], $i, $i );
                            } else{
                                if(isset($_GET['job_id'])){
                                    printf("<a class='page-numbers current' %shref='%s?job_id=%u&page=%u'>%u</a>", 
                                        $i==$page ? : "", $curr_file,$_GET['job_id'] ,$i, $i );
                                } else{
                                    printf("<a class='page-numbers current' %shref='%s?page=%u'>%u</a>", 
                                        $i==$page ? : "", $curr_file, $i, $i );
                                }
                            }
                        }
                    }
                    else{
                        if(strpos($url, "search")){
                            if(isset($_GET['drop_down_menu'])){
                                printf("<a class='page-numbers' %shref='%s?drop_down_menu=%u&search=%s&page=%u'>%u</a>", 
                                $i==$page ? : "", $curr_file, $_GET['drop_down_menu'], $_GET['search'], $i, $i);
                            } else{
                                printf("<a class='page-numbers' %shref='%s?search=%s&page=%u'>%u</a>", 
                                $i==$page ? : "", $curr_file, $_GET['search'], $i, $i);
                            }
                        } else{
                            if(isset($_GET['job_id'])){
                                printf("<a class='page-numbers' %shref='%s?job_id=%u&page=%u'>%u</a>", 
                                    $i==$page ? : "", $curr_file,$_GET['job_id'] ,$i, $i );
                            } else{
                                printf("<a class='page-numbers' %shref='%s?page=%u'>%u</a>", 
                                    $i==$page ? : "", $curr_file, $i, $i );
                            }
                        }
                    }
            }?>
        </div>
    </div>
<?php } ?>