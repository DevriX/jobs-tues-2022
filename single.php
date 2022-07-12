<!DOCTYPE html>
<html lang="en">

<?php include 'header.php';
require_once 'classes/Db-connection.php';

$db = new Requests;
    
$conn = $db->connectDB();

//var_dump($_GET);
$job_id = $_GET['job-id'];

//var_dump($job_id);

if($job_id != null){
	$statement_job = "SELECT * FROM jobs WHERE id = " . $_GET['job-id'];

	$result_job = mysqli_query($conn, $statement_job);

	$job = mysqli_fetch_all($result_job,MYSQLI_ASSOC);
}
// if($job_id == null){
// 	$statement = "SELECT * FROM jobs";

// 	$result = mysqli_query($conn, $statement);

// 	$job = mysqli_fetch_all($result,MYSQLI_ASSOC);
// }

if($job_id != null){
	$statement_related_jobs = 
			"SELECT *
			FROM jobs_categories Categories
			LEFT JOIN jobs Jobs ON Categories.job_id = Jobs.id
			WHERE Jobs.id != $job_id
			LIMIT 0, 3";

	$results = mysqli_query($conn, $statement_related_jobs);

	$related_jobs = mysqli_fetch_all($results,MYSQLI_ASSOC);
}
//var_dump($related_jobs);

?>

<body>
	<div class="site-wrapper">
		<?php if($job_id != null){ ?>
			<main class="site-main">
				<section class="section-fullwidth">
					<div class="row">
						<div class="job-single">
							<div class="job-main">
								<div class="job-card">
									<div class="job-primary">
										<header class="job-header"> 
												<?php foreach($job as $i => $arguments){ ?>
													<h2 type="" class="job-title"><?php echo $arguments['title'] ?></h2>
													<div class="job-meta">
														<a class="meta-company" href="#">Company Awesome Ltd.</a>
														<span class="meta-date">Posted on: <?php echo $arguments['date_posted'] ?></span>
													</div>
													<div class="job-details">
														<span class="job-location"><?php echo $arguments['location'] ?></span>
														<span class="job-type">Contract staff</span>
														<span class="job-price"><?php echo $arguments['salary'] ?> Lv.</span>
													</div>
												<?php } ?>
										</header>
											<?php foreach($job as $i => $arguments){ ?>
												<div class="job-body">
													<P><?php echo $arguments['description']?> </P>
												</div>
											<?php } ?>
									</div>
								</div>
							</div>
							<aside class="job-secondary">
								<div class="job-logo">
									<div class="job-logo-box">
										<img src="https://i.imgur.com/ZbILm3F.png" alt="">
									</div>
								</div>
								<a href="apply-submission.php" class="button button">Apply now</a>
								<a href="#" class="button button">Edit now</a>
								<a href="https://www.CompanyAwesomeLtd..com/">Link to the company</a>
							</aside>
						</div>
					</div>
				</section>
			</main>
			<section class="section-fullwidth">
					<div class="row">
						<h2 class="section-heading">Other related jobs:</h2>
							<?php foreach($related_jobs as $jobs){ ?>
									<ul class="jobs-listing">
										<li class="job-card">
											<div class="job-primary">
												<h2 class="job-title"><a href="single.php?job-id=<?php echo $jobs['id']; ?>"><?php echo $jobs['title']?></a></h2>
												<div class="job-meta">
													<a class="meta-company" href="#">Company Awesome Ltd.</a>
													<span class="meta-date">Posted on: <?php echo $jobs['date_posted'] ?></span>
												</div>
												<div class="job-details">
													<span class="job-location"><?php echo $jobs['location'] ?></span>
													<span class="job-type">Contract staff</span>
													<span class="job-price"><?php echo $jobs['salary'] ?> Lv.</span>
												</div>
											</div>
											<div class="job-logo">
												<div class="job-logo-box">
													<img src="https://i.imgur.com/ZbILm3F.png" alt="">
												</div>
											</div>
										</li>
									</ul>
							<?php } ?>
					</div>
				</section>
			<?php } ?>
	</div>
	<?php include 'footer.php';?>
</body>
</html> 