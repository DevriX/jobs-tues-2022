<!DOCTYPE html>
<html lang="en">

<body>
<?php 
include 'header.php';

if($_SERVER["REQUEST_METHOD"] == "GET"){
	if(!empty($_GET["status"])){
		if($_GET['status'] == "a"){
			$approve_request = "UPDATE jobs SET status = 1 WHERE jobs.id = " . $_GET['job_id'] . "";

			if ($conn->query($approve_request) === FALSE) {
				echo "Error: " . $approve_request . "<br>" . $conn->error;
			}
		} else {
			$reject_request = "UPDATE jobs SET status = 0 WHERE jobs.id = " . $_GET['job_id'] . "";
		
				
			if ($conn->query($reject_request) === FALSE) {
				echo "Error: " . $delete_request . "<br>" . $conn->error;
			}
		}
	}
}

?>
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
						<div class="secondary-container">
							<div class="flex-container centered-vertically">
								<div class="search-form-wrapper">
									<div class="search-form-field"> 
										<input class="search-form-input" type="text" value="" placeholder="Search…" name="search" > 
									</div> 
								</div>
								<div class="filter-wrapper">
									<div class="filter-field-wrapper">
										<select name="menu">
											<option value="1">Date</option>
											<option value="2">Alphabetically</option>
										</select>
									</div>
								</div>
								<div class="button-wrapper">
									<form method="post" style="margin-left: 10px; margin-top: -15px;">
										<button name="filter" class="button" type="submit">Submit</button>
									</form>
								</div>
							</div>
						</div>
					</div>
					<ul class="jobs-listing">
						<?php 
							$request = "SELECT *, jobs.id AS 'main_id', DATEDIFF(CURDATE(), jobs.date_posted) AS 'date' FROM jobs 
								 LEFT JOIN users ON jobs.user_id = users.id
								 ORDER BY date_posted DESC";

if(mysqli_num_rows($request) > 0){
	while($row = mysqli_fetch_array($request, MYSQLI_BOTH)){
		?>
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
		<?php }} ?>
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