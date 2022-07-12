<!DOCTYPE html>
<html lang="en">

<?php include 'header.php';?>

<body>
	<div class="site-wrapper">

		<main class="site-main">
			<section class="section-fullwidth">
				<div class="row">						
					<ul class="tabs-menu">
						<li class="menu-item current-menu-item">
							<a href="dashboard.php">Jobs</a>					
						</li>
						<li class="menu-item">
							<a href="category-dashboard.php">Categories</a>
						</li>
					</ul>
					<?php
					$limit = 5;

					if (!isset ($_GET['page']) ) {  
						$page = 1;  
					} else {  
						$page = $_GET['page'];  
					}

					$atributes = ['search', 'drop_down_menu', 'job_id'];
					
					$request_application = "SELECT jobs.id, jobs.title, users.first_name, users.last_name, applications.user_id 
							FROM applications 
							LEFT JOIN jobs ON applications.job_id=jobs.id 
							LEFT JOIN users ON applications.user_id=users.id
							WHERE jobs.id=" . $_GET['job_id'] ."";

					$page_first_result = ($page-1) * $limit;
					$num_rows = mysqli_num_rows ($conn->query($request_application));
					$page_total = ceil($num_rows / $limit);
					$request_info = $conn->query($request_application." LIMIT $page_first_result, $limit");

					?> <ul class="jobs-listing"> <?php
					$title_check = 0;
					if(mysqli_num_rows($request_info) > 0){
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
								pagination($page, $page_total, $atributes);
									}else { 
									$request_job_title = $conn->query(
										"SELECT jobs.title FROM jobs WHERE jobs.id=" . $_GET['job_id'] ."");
									$job_row = mysqli_fetch_array($request_job_title, MYSQLI_BOTH) ?>
									<h2 class="heading-title"><?php echo $job_row['title'];?> - Submissions - 0 Appliciants</h2>
								<?php } ?>
						
					</ul>
				</div>
			</section>
		</main>
	</div>
	<?php include 'footer.php';?>
</body>
</html>