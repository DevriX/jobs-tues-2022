<!DOCTYPE html>
<html lang="en">

<?php include 'header.php';?>

<?php 
	$request_category = $conn->query("SELECT * FROM categories");

	while($row = mysqli_fetch_array($request_category, MYSQLI_BOTH)){

	}
?>

<body>
	<div class="site-wrapper">

		<main class="site-main">
			<section class="section-fullwidth section-jobs-dashboard">
				<div class="row">						
					<div class="jobs-dashboard-header">
						<div class="primary-container">							
							<ul class="tabs-menu">
								<li class="menu-item">
									<a href="#">Jobs</a>					
								</li>
								<li class="menu-item current-menu-item">
									<a href="#">Categories</a>
								</li>
							</ul>
						</div>
						<div class="secondary-container">
							<div class="form-box category-form">
								<form>
									<div class="flex-container justified-vertically">									
										<div class="form-field-wrapper">
											<input type="text" placeholder="Enter Category Name..."/>
										</div>
										<button class="button">
											Add New
										</button>
									</div>	
								</form>
							</div>
						</div>
					</div>
					<ul class="jobs-listing">

					<?php 
						$request_category = $conn->query("SELECT * FROM categories");

						while($row = mysqli_fetch_array($request_category, MYSQLI_BOTH)){
					?>

						<li class="job-card">
							<div class="job-primary">
								<h2 class="job-title"><?php echo $row["title"]?></h2>
							</div>
							<div class="job-secondary centered-content">
								<div class="job-actions">
									<a href="#" class="button button-inline">Delete</a>
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