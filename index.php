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
						
						$url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
						if(strpos($url, "search")){
							$is_searched = true;				
							var_dump($_GET['search']);
							if(isset($_GET['search'])){
								$request_search = "SELECT j.title, j.location, DATEDIFF(CURDATE(), j.date_posted) AS 'date', u.company_name, u.company_image
														FROM jobs as j JOIN users as u on u.id = j.user_id
														HAVING (j.title LIKE '%".$_GET['search']."%')  
														ORDER BY date_posted DESC";
							}

							pagination($request_search, $request_search); 
						}

						else{ 
								$sql_request = "SELECT j.title, j.location, DATEDIFF(CURDATE(), j.date_posted) AS 'date', u.company_name, u.company_image
												FROM jobs as j JOIN users as u on u.id = j.user_id 
												ORDER BY date_posted DESC";
								$num_rows_sql_request = "SELECT * FROM jobs";
								pagination($sql_request, $num_rows_sql_request);
							} ?>
				</div>
			</section>	
		</main>
	</div>

	<?php include 'footer.php';?>
</body>
</html>