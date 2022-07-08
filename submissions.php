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
						$request_application = $conn->query("SELECT * FROM applications LEFT JOIN jobs ON applications.job_id=jobs.id LEFT JOIN users ON applications.user_id=users.id");

						$count_appliciants = $conn->query("SELECT COUNT(applications.user_id) as apps FROM applications LEFT JOIN users ON applications.user_id=users.id GROUP BY applications.job_id");

						$request_appliciant = $conn->query("SELECT users.first_name, users.last_name FROM applications LEFT JOIN users ON applications.user_id=users.id GROUP BY applications.job_id");

						$appliciants_row = mysqli_fetch_array($count_appliciants, MYSQLI_BOTH);

						$application_row = mysqli_fetch_array($request_application, MYSQLI_BOTH);
					?>
					<div class="section-heading">
						<h2 class="heading-title"><?php echo $application_row["title"]?> - Submissions - <?php echo $appliciants_row["apps"] ?></h2>
					</div>
					<ul class="jobs-listing">
						<?php 
							while($request_appliciant = mysqli_fetch_array($request_application, MYSQLI_BOTH)){
						?>
							<li class="job-card">
								<div class="job-primary">
									<h2 class="job-title"><?php echo "" . $request_appliciant["first_name"] . " " . $request_appliciant["last_name"] . ""?></h2>
								</div>
								<div class="job-secondary centered-content">
									<div class="job-actions">
										<a href="view-submission.php?user_id=<?php echo $request_appliciant['id']; ?>" class="button button-inline">View</a>
									</div>
								</div>
							</li>
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