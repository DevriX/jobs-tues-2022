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
						$request_application = $conn->query(
							"SELECT jobs.id, jobs.title, users.first_name, users.last_name, applications.user_id 
							 FROM applications 
							 LEFT JOIN jobs ON applications.job_id=jobs.id 
							 LEFT JOIN users ON applications.user_id=users.id
							 WHERE jobs.id=" . $_GET['job_id'] ."");

						$title_check = 0;
						if(mysqli_num_rows($request_application) > 0){
							while($application_row = mysqli_fetch_array($request_application, MYSQLI_BOTH)){
					?>
					<div class="section-heading">
						<?php if(!$title_check){?>
							<h2 class="heading-title"><?php echo $application_row["title"];?> - Submissions - <?php echo mysqli_num_rows( $request_application); ?> Appliciants</h2>
						<?php $title_check=1; }?>	
					</div>
					<ul class="jobs-listing">
							<li class="job-card">
								<div class="job-primary">
									<h2 class="job-title"><?php echo "" . $application_row["first_name"] . " " . $application_row["last_name"] . "";?></h2>
								</div>
								<div class="job-secondary centered-content">
									<div class="job-actions">
										<a href="view-submission.php?user_id=<?php echo $application_row['user_id']; ?>" class="button button-inline">View</a>
									</div>
								</div>
							</li>
						<?php }
								} else { 
									$request_job_title = $conn->query(
										"SELECT jobs.title FROM jobs WHERE jobs.id=" . $_GET['job_id'] ."");
									$job_row = mysqli_fetch_array($request_job_title, MYSQLI_BOTH) ?>
									<h2 class="heading-title"><?php echo $job_row['title'];?> - Submissions - 0 Appliciants</h2>
								<?php } ?>
						
					</ul>					
					<div class="jobs-pagination-wrapper">
						<div class="nav-links"> 
							<a class="page-numbers current">1</a> 
							<a class="page-numbers">2</a> 
							<a class="page-numbers">3</a> 
							<a class="page-numbers">4</a> 
							<a class="page-numbers">5</a> 
						</div>
					</div>
				</div>
			</section>
		</main>
	</div>
	<?php include 'footer.php';?>
</body>
</html>