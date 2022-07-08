<!DOCTYPE html>
<html lang="en">

<?php include 'header.php';?>

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
?>

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
							<div class="search-form-field" method = "get">
								<form method = "get">	 
									<input class="search-form-input" type="text" value="" placeholder="Search…" name="search">
								</form>
								
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
						$is_searched = false;
							if(isset($_GET["search"])){
								$is_searched = true;				
								$key_word = $_GET["search"];
								$request_job_info = $conn->query("SELECT j.title, j.location, DATEDIFF(CURDATE(), j.date_posted) AS 'date', u.company_name, u.company_image
														FROM jobs as j JOIN users as u on u.id = j.user_id
														HAVING (j.title LIKE '%".$key_word."%')  
														ORDER BY date_posted DESC");
								
								while($row = mysqli_fetch_array($request_job_info, MYSQLI_BOTH)) {
									$company_image_path = "/uploads/company_images/".$row["company_image"];?>
									<li class="job-card">
										<div class="job-primary">
											<h2 class="job-title"><a href="#"><?php echo $row["title"];?></a></h2>
											<div class="job-meta">
												<a class="meta-company" href="#"><?php echo $row["company_name"];?></a>
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
							<?php } 
							} 

  
							$limit = 5;

							if (!isset ($_GET['page']) ) {  
								$page = 1;  
							} else {  
								$page = $_GET['page'];  
							}
							 
							$page_first_result = ($page-1) * $limit;

							
							if($is_searched == false){	
									$request_job_info = $conn->query("SELECT j.title, j.location, DATEDIFF(CURDATE(), j.date_posted) AS 'date', u.company_name, u.company_image
																	FROM jobs as j JOIN users as u on u.id = j.user_id 
																	ORDER BY date_posted DESC 
																	LIMIT $page_first_result, $limit");
									
									$num_rows = mysqli_num_rows ($conn->query("SELECT * FROM jobs"));
								

								
									$page_total = ceil($num_rows / $limit);

									while($row = mysqli_fetch_array($request_job_info, MYSQLI_BOTH)) {
										$company_image_path = "/uploads/company_images/".$row["company_image"];?>
										<li class="job-card">
											<div class="job-primary">
												<h2 class="job-title"><a href="#"><?php echo $row["title"];?></a></h2>
												<div class="job-meta">
													<a class="meta-company" href="#"><?php echo $row["company_name"];?></a>
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
								<?php  } ?>		
									
								</ul>
								<div class="jobs-pagination-wrapper">
									<div class="nav-links">
										<?php 
											for ($i = 1; $i <= $page_total; $i++) {

													if($i == $page){
														printf("<a class='page-numbers current' %shref='index.php?page=%u'>%u</a>", 
															$i==$page ? : "", $i, $i );
													}
													else{
														printf("<a class='page-numbers' %shref='index.php?page=%u'>%u</a>", 
															$i==$page ? : "", $i, $i );
													}
												}
							
							}?>
						</div>
					</div>
				</div>
			</section>	
		</main>
	</div>

	<?php include 'footer.php';?>
</body>
</html>