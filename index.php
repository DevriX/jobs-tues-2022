<!DOCTYPE html>
<html lang="en">

<?php include 'header.php';?>

<body>

	<div class="site-wrapper">

		<main class="site-main">
			<section class="section-fullwidth section-jobs-preview">
				<div class="row">
					<form method = "get">
						<?php
						if(isset($_GET['filter'])){
						
							foreach($_GET['filter'] as $filter){
						?>
								<input type="hidden" name='filter[]' value='<?php echo $filter;?>'>
							
						<?php
							}
						//var_dump($_GET['filter[]']);
						}
						?> 	
							<ul class="tags-list">
							<?php 
							$request_category_homepage = $conn->query("SELECT title, id 
																			FROM categories 
																			ORDER BY title ASC");
							
							$url = $_SERVER['REQUEST_URI'];
							if(!strpos($url, "?")){
								$url = $url."?";
							}

							while($row = mysqli_fetch_array($request_category_homepage, MYSQLI_BOTH)){ 
							$style = "";
							if(isset($_GET['filter'])){
								foreach($_GET['filter'] as $filter){
									if($filter == $row['id']){
										$style = 'style="background-color: #a1a9b5; pointer-events: none; cursor: default;"';
									}
								}
								
							}

							?>
								<li class="list-item">
									<a <?php echo $style;?> href="<?php echo urldecode(change_url_parameter(url_path_http().$url, 'filter[]', $row['id']))?>"  class="list-item-link"><?php echo $row['title'];?></a>
								</li>
							<?php 
							} 
							?>
							</ul>
						
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
									<button class="button" style="margin-top:3px;margin-left:10px;" type="submit" name="submit"> Submit </button>
									</div>
								</div>
							</div>
					</form>
					<ul class="jobs-listing">
						<?php
						
						if(isset($_GET['drop_down_menu']) && $_GET['drop_down_menu'] == 2){
							$order_list = "title ASC";
						} else{
							$order_list = "date_posted DESC";
						}

						$search_key_word = "";
						if(strpos($url, "search")){				
							if(isset($_GET['search'])){
								$search_key_word = "AND j.title LIKE '%".$_GET['search']."%'";
							}
						}

						$filter_request = array(
							'join' => "",
							'where' => ""
						);
						if(isset($_GET['filter'])){
							$filter_request = array(
								'join' => "JOIN jobs_categories AS jc ON j.id=jc.job_id",
								'where' => "AND jc.category_id IN (".implode(',', $_GET['filter']). ")"
							);
						}

						$sql_request = "SELECT  j.id, j.title, j.location, 
												DATEDIFF(CURDATE(), j.date_posted) AS 'date', 
												u.company_name, u.company_image
										FROM jobs as j
										".$filter_request['join']." 
										JOIN users as u 
										on u.id = j.user_id
										WHERE 1 = 1 ".$search_key_word."
										".$filter_request['where']." 
										ORDER BY $order_list";
							
							$page_first_result = ($page-1) * RES_LIMIT;
							$num_rows = mysqli_num_rows ($conn->query($sql_request));
							$page_total = ceil($num_rows / RES_LIMIT);
							$request_info = $conn->query($sql_request." LIMIT " . $page_first_result . ','. RES_LIMIT);

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
						<?php  
						}
						?>
						<div class="jobs-pagination-wrapper">
							<div class="nav-links">
								<?php pagination($page, $page_total); ?>
							</div>
						</div>
					</ul>
				</div>
			</section>	
		</main>
	</div>

	<?php include 'footer.php';?>
</body>
</html>