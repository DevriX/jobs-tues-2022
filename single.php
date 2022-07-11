<!DOCTYPE html>
<html lang="en">

<?php include 'header.php';
require_once 'classes/Db-connection.php';

$db = new Requests;
    
$conn = $db->connectDB();

$statement = "SELECT * FROM jobs";
$result = mysqli_query($conn, $statement);

$jobs = mysqli_fetch_all($result,MYSQLI_ASSOC);
?>

<body>
	<div class="site-wrapper">
		<form action="single.php" method="get">
		<main class="site-main">
			<section class="section-fullwidth">
				<div class="row">
					<div class="job-single">
						<div class="job-main">
							<div class="job-card">
								<div class="job-primary">
									<header class="job-header">
										<?php foreach($jobs as $i => $job){ ?>
											<h2 type="submit" class="job-title"><a href="#">Front End Developer</a><?php echo $job['id'];?></h2>
											<div class="job-meta">
												<a class="meta-company" href="#">Company Awesome Ltd.</a>
												<span class="meta-date">Posted 14 days ago</span>
											</div>
											<div class="job-details">
												<span class="job-location">The Hague (The Netherlands)</span>
												<span class="job-type">Contract staff</span>
												<span class="job-price">1500лв.</span>
											</div>
										<?php } ?>
									</header>

									<div class="job-body">
										<h3>We and our partners process data to provide:</h3>
										<P>Use precise geolocation data. Actively scan device characteristics for identification. </P>
										<P>Store and/or access information on a device. Personalised ads and content, ad and content measurement,</P> 
										<P>audience insights and product development.</P>
										<h3>Responsibilities</h3>
										<p>You’ll be part of a development team working on our flagship products. It’s going to be epic!</p>
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
							<a href="apply-submission.php" class="button button">Apply now</a>
							<a href="#" class="button button">Edit now</a>
							<a href="https://www.CompanyAwesomeLtd..com/">Link to the company</a>
						</aside>
					</div>
				</div>
			</section>
		</main>
		</form>
	</div>
	<?php include 'footer.php';?>
</body>
</html> 