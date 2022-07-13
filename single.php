<!DOCTYPE html>
<html lang="en">

<?php include 'header.php';
require_once 'classes/Db-connection.php';

$db = new Requests;
    
$conn = $db->connectDB();

//var_dump($_GET);
$job_id = $_GET['job_id'];

//var_dump($job_id);

if($job_id != null){
	$sql = "SELECT * 
			FROM jobs 
			LEFT JOIN users ON jobs.user_id=users.id 
			WHERE jobs.id = " . $_GET['job_id'] . " ";
	$result = mysqli_query($conn, $sql);
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		if(empty($row)){
			echo "0 results";
		}
	}
	//var_dump($row);

	$statement_related_jobs = 
			"SELECT *
			FROM jobs_categories 
			LEFT JOIN jobs ON jobs.id = jobs_categories.job_id 
			LEFT JOIN users ON jobs.user_id=users.id
			WHERE  job_id != $job_id AND category_id 
			IN (SELECT subquery.category_id FROM jobs_categories subquery WHERE job_id = $job_id )
			ORDER BY rand() ";

	$results_related_jobs = mysqli_query($conn, $statement_related_jobs);

	$related_jobs = mysqli_fetch_all($results_related_jobs,MYSQLI_ASSOC);
}

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
													<h2 class="job-title"><?php echo $row['title'] ?></h2>
													<div class="job-meta">
														<a class="meta-company" href="#"><?php echo $row["company_name"]; ?></a>
														<span class="meta-date">Posted on: <?php echo $row['date_posted'] ?></span>
													</div>
													<div class="job-details">
														<span class="job-location"><?php echo $row['location'] ?></span>
														<span class="job-type">Contract staff</span>
														<span class="job-price"><?php echo $row['salary'] ?> Lv.</span>
													</div>
										</header>
												<div class="job-body">
													<P><?php echo $row['description']?> </P>
												</div>
									</div>
								</div>
							</div>
							<aside class="job-secondary">
								<div class="job-logo">
									<div class="job-logo-box">
										<img src="https://i.imgur.com/ZbILm3F.png" alt="">
									</div>
								</div>
								<a href="apply-submission.php?job_id=<?php echo($_GET['job_id']) ?>" class="button button">Apply now</a>
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
												<h2 class="job-title"><a href="single.php?job_id=<?php echo $jobs['id']; ?>"><?php echo $jobs['title']?></a></h2>
												<div class="job-meta">
													<a class="meta-company" href="#"><?php echo $jobs["company_name"]; ?></a>
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