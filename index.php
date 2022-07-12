<!DOCTYPE html>
<html lang="en">

<?php include 'header.php';?>

<body>

	<div class="site-wrapper">

		<main class="site-main">
			<section class="section-fullwidth section-jobs-preview">
				<div class="row">	
					<ul class="tags-list">
					<?php $request_category_homepage = $conn->query("SELECT title FROM categories ORDER BY title ASC");
					while($row = mysqli_fetch_array($request_category_homepage, MYSQLI_BOTH)){ ?>
						<li class="list-item">
							<a href="#" class="list-item-link"><?php echo $row['title']; ?></a>
						</li>
				<?php } ?>
					</ul>
					<form method = "get">
						<div class="flex-container centered-vertically">
							<div class="search-form-wrapper">
								<div class="search-form-field" method = "get">
									<input class="search-form-input" type="text" placeholder="Search..." value='<?php if (isset($_GET['search'])) echo $_GET['search'];?>' name="search">
								</div> 
							</div>
							<?php
							if (!empty($_GET['drop_down_menu'])) {
								$drop_down_val = $_GET['drop_down_menu'];
							} else {
								$drop_down_val = 1;
							}
							?>
							<form>
								<div style="display: flex">
									<div class="filter-wrapper">
										<div class="filter-field-wrapper">
											<select name='drop_down_menu'>
												<option value="1" <?php if ($drop_down_val == 1) echo 'selected="selected"'; ?>>By Date</option>;
												<option value="2" <?php if ($drop_down_val == 2) echo 'selected="selected"'; ?>>Alphabetically</option>;
											</select>
										</div>
									</div>
									<div>
											<button class="button" style="margin-top: 3px; margin-left: 10px;" type="submit" name="submit" >
														Submit
											</button>
									</div>
								</div>
							</form>
							
						</div>
					</form>
					<ul class="jobs-listing">
					<?php
						
						if(isset($_GET['drop_down_menu']) && $_GET['drop_down_menu'] == 2){
							$order_list = "title ASC";
						} else{
							$order_list = "date_posted DESC";
						}
						
						$url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

						$limit = 5;

						if (!isset ($_GET['page']) ) {  
							$page = 1;  
						} else {  
							$page = $_GET['page'];  
						}

						$atributes = ['search', 'drop_down_menu'];
						if(strpos($url, "search")){				
							if(isset($_GET['search'])){
								$sql_request = "SELECT j.title, j.location, DATEDIFF(CURDATE(), j.date_posted) AS 'date', u.company_name, u.company_image
														FROM jobs as j JOIN users as u on u.id = j.user_id
														HAVING (j.title LIKE '%".$_GET['search']."%')  
														ORDER BY $order_list";
							}
						} else{
								$sql_request = "SELECT j.title, j.location, DATEDIFF(CURDATE(), j.date_posted) AS 'date', u.company_name, u.company_image
												FROM jobs as j JOIN users as u on u.id = j.user_id 
												ORDER BY $order_list";
							} 
							
							$page_first_result = ($page-1) * $limit;
							$num_rows = mysqli_num_rows ($conn->query($sql_request));
							$page_total = ceil($num_rows / $limit);
							$request_info = $conn->query($sql_request." LIMIT $page_first_result, $limit");

					?> <ul class="jobs-listing"> <?php
					while($row = mysqli_fetch_array($request_info, MYSQLI_BOTH)) {
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
				<?php  }
						pagination($page, $page_total, $atributes); ?>
					</ul>
				</div>
			</section>	
		</main>
	</div>

	<?php include 'footer.php';?>
</body>
</html>