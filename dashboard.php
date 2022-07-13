<!DOCTYPE html>
<html lang="en">

<script type="text/javascript" src="engine1/jquery.js"></script> 

<?php 
include 'header.php';

if($_SERVER["REQUEST_METHOD"] == "GET"){
	/*
	if(!empty($_GET["status"])){
		if($_GET['status'] == "a"){
			$approve_request = "UPDATE jobs SET status = 1 WHERE id = " . $_GET['job_id'] . "";

			if ($conn->query($approve_request) === FALSE) {
				echo "Error: " . $approve_request . "<br>" . $conn->error;
			}
		} else {
			$reject_request = "UPDATE jobs SET status = 0 WHERE id = " . $_GET['job_id'] . "";
		
				
			if ($conn->query($reject_request) === FALSE) {
				echo "Error: " . $delete_request . "<br>" . $conn->error;
			}
		}
	}*/

	// if(!empty($_GET['delete'])){
	// 	// $delete_job_request =
	// 	// 			"DELETE jobs, jobs_categories, applications
	// 	// 			 FROM jobs
	// 	// 			 LEFT JOIN jobs_categories ON jobs.id = jobs_categories.job_id
	// 	// 			 LEFT JOIN applications ON jobs.id = applications.job_id
	// 	// 			 WHERE jobs.id=" . $_GET['job_id'] . " ";
		
 	// 	$delete_categories_request = 
	// 				"DELETE FROM jobs_categories
	// 				 WHERE job_id=" . $_GET['job_id'] . " ";
	// 	if ($conn->query($delete_categories_request) === FALSE) {
	// 		echo "Error: " . $delete_categories_request . "<br>" . $conn->error;
	// 	}

	// 	$delete_appliciants_request = "DELETE FROM applications WHERE job_id = " . $_GET['job_id'] . " ";
	// 	if ($conn->query($delete_appliciants_request) === FALSE) {
	// 		echo "Error: " . $delete_appliciants_request . "<br>" . $conn->error;
	// 	}

	// 	$delete_job_request = "DELETE FROM jobs WHERE jobs.id=" . $_GET['job_id'] . " ";
	// 	if ($conn->query($delete_job_request) === FALSE) {
	// 		echo "Error: " . $delete_request . "<br>" . $conn->error;
	// 	}
	// }

	$order = 'date_posted DESC';
	if(isset($_GET['drop_down_menu']) && $_GET["drop_down_menu"] == 2){
		$order = 'title ASC';
	}

	$search = '';
	if(!empty($_GET['search'])){
		$search = $_GET['search'];
	}

	if (!empty($_GET['drop_down_menu'])) {
		$menu_value = $_GET['drop_down_menu'];
	} else {
		$menu_value = 1;
	}

	$request = "SELECT *, jobs.id AS 'job_id', DATEDIFF(CURDATE(), jobs.date_posted) AS 'date' 
		FROM jobs 
		LEFT JOIN users ON jobs.user_id = users.id
		HAVING title LIKE '%" . $search . "%'
		ORDER BY " . $order . "";
}

?>

<body>
	<div class="site-wrapper">

		<main class="site-main">
			<section class="section-fullwidth section-jobs-dashboard">
				<div class="row">
					<div class="jobs-dashboard-header flex-container centered-vertically justified-horizontally">
						<div class="primary-container">							
							<ul class="tabs-menu">
								<li class="menu-item current-menu-item">
									<a href="dashboard.php">Jobs</a>					
								</li>
								<li class="menu-item">
									<a href="category-dashboard.php">Categories</a>
								</li>
							</ul>
						</div>
						<div  style="display:inline-flex;" class="secondary-container">
							<div class="flex-container centered-vertically">
								<form>
									<div style="display:inline-flex;" class="search-form-wrapper">
										<div class="search-form-field"> 
											<input class="search-form-input" type="text" value="<?php if (isset($_GET['search'])) echo $_GET['search'];?>" placeholder="Search…" name="search" > 
										</div> 
									</div>
									<div style="display:inline-flex;" class="filter-wrapper">
										<div class="filter-field-wrapper">
											<select name="drop_down_menu">
												<option value="1" <?php if ($menu_value == 1) echo 'selected="selected"'; ?>>Date</option>
												<option value="2" <?php if ($menu_value == 2) echo 'selected="selected"'; ?>>Alphabetically</option>
											</select>
										</div>
									</div>
									<div style="display: inline-flex; margin-left: -10px;" class="button-wrapper">
										<form method="post">
											<button class="button" type="submit">Submit</button>
										</form>
									</div>
								</form>
							</div>
						</div>
					</div>
					<?php 
					$limit = 5;

					if (!isset ($_GET['page']) ) {  
						$page = 1;  
					} else {  
						$page = $_GET['page'];  
					}

					$atributes = ['search', 'drop_down_menu'];
					$page_first_result = ($page-1) * $limit;
					$num_rows = mysqli_num_rows ($conn->query($request));
					$page_total = ceil($num_rows / $limit);
					$request_info = $conn->query($request." LIMIT $page_first_result, $limit");
					?> 
					<ul class="jobs-listing"> 
					<?php
					while($row = mysqli_fetch_array($request_info, MYSQLI_BOTH)) { ?>
						<li id="card" class="job-card">
							<div class="job-primary">
								<h2 class="job-title"><a href="submissions.php?job_id=<?php echo $row['job_id']; ?>"><?php echo $row["title"]; ?></a></h2>
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
										<a <?php if($row['status'] == 1){ ?> style="display:none" <?php } ?> id="approve" data-id="<?php echo $row['job_id'];?>" class="approve-button" href="<?php echo $_SERVER["PHP_SELF"]?>?search=<?php echo $search; ?>&drop_down_menu=<?php echo $menu_value; ?>&job_id=<?php echo $row['job_id'];?>"> Approve </a>

										<a <?php if($row['status'] == 0){ ?> style="display:none" <?php } ?> id="reject" data-id="<?php echo $row['job_id'];?>" class="reject-button" href="<?php echo $_SERVER["PHP_SELF"]?>?search=<?php echo $search; ?>&drop_down_menu=<?php echo $menu_value; ?>&job_id=<?php echo $row['job_id'];?>">Reject</a>

										<a id="delete" data-id="<?php echo $row['job_id'];?>" class="delete-button" href="<?php echo $_SERVER["PHP_SELF"]?>?search=<?php echo $search; ?>&drop_down_menu=<?php echo $menu_value; ?>&job_id=<?php echo $row['job_id'];?>" class="delete-button"> Delete </a>
									</form>
								</div>
								<div class="job-edit">
									<a href="submissions.php?job_id=<?php echo $row['job_id']; ?>">View Submissions</a>
									<a href="actions-job.php?edit_job=<?php echo $row['job_id']?>">Edit</a>
								</div>
							</div>
						</li>
						<?php  } 
						pagination($page, $page_total, $atributes);
						?>
						</ul>		
				</div>
			</section>
		</main>
	</div>
	<?php include 'footer.php';?>
</body>
</html>