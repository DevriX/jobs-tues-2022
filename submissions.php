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
						$request_application = "SELECT jobs.id, jobs.title, users.first_name, users.last_name, applications.user_id 
							 FROM applications 
							 LEFT JOIN jobs ON applications.job_id=jobs.id 
							 LEFT JOIN users ON applications.user_id=users.id
							 WHERE jobs.id=" . $_GET['job_id'] ."";

						pagination($request_application);
						?>
				</div>
			</section>
		</main>
	</div>
	<?php include 'footer.php';?>
</body>
</html>