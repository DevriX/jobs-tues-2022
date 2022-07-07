<!DOCTYPE html>
<html lang="en">

<?php include 'header.php';?>

<body>

	<div class="site-wrapper">

		<main class="site-main">
			<section class="section-fullwidth section-jobs-preview">
				<div class="row">	
					<ul class="tags-list">
						<li class="list-item">
							<a href="#" class="list-item-link">IT</a>
						</li>
						<li class="list-item">
							<a href="#" class="list-item-link">Manufactoring</a>
						</li>
						<li class="list-item">
							<a href="#" class="list-item-link">Commerce</a>
						</li>
						<li class="list-item">
							<a href="#" class="list-item-link">Architecture</a>
						</li>
						<li class="list-item">
							<a href="#" class="list-item-link">Marketing</a>
						</li>
					</ul>
					<div class="flex-container centered-vertically">
						<div class="search-form-wrapper">
							<div class="search-form-field"> 
								<input class="search-form-input" type="text" value="" placeholder="Search…" name="search" > 
							</div> 
						</div>
						<div class="filter-wrapper">
							<div class="filter-field-wrapper">
								<select>
									<option value="1">Date</option>
									<option value="2">Date</option>
									<option value="3">Date</option>
									<option value="4">Type</option>
								</select>
							</div>
						</div>
					</div>
					<ul class="jobs-listing">
						<?php 
							function time_diff_mesage($diff){
								switch($diff){
									case 0:
										echo " today."; break;
									case 1:
										echo " yesterday."; break;
									default:
										echo $diff." days ago.";
								}
							}


							$request_job_info = $conn->query("SELECT title, location, DATEDIFF(CURDATE(), date_posted) AS 'date' FROM jobs");
							$request_company_info = $conn->query("SELECT * FROM users as u JOIN jobs as j on j.user_id = u.id");
							
							while($row = mysqli_fetch_array($request_job_info, MYSQLI_BOTH)) { 
								$company_info = mysqli_fetch_array($request_company_info, MYSQLI_BOTH);
								
								$company_image_path = "/uploads/company_images/".$company_info["company_image"];?>
								<li class="job-card">
									<div class="job-primary">
										<h2 class="job-title"><a href="#"><?php echo $row["title"];?></a></h2>
										<div class="job-meta">
											<a class="meta-company" href="#"><?php echo $company_info["company_name"];?></a>
											<span class="meta-date">Posted <?php echo time_diff_mesage($row["date"]);?></span>
										</div>
										<div class="job-details">
											<span class="job-location"><?php echo $row["location"];?></span>
											<span class="job-type">Contract staff</span>
										</div>
									</div>
									<div class="job-logo">
										<div class="job-logo-box">
											<img src=<?php echo $company_image_path;?> alt="">
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