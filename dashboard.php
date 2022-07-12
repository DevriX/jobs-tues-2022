<!DOCTYPE html>
<html lang="en">

<body>
<?php 
include 'header.php';

if($_SERVER["REQUEST_METHOD"] == "GET"){
	if(!empty($_GET["status"])){
		if($_GET['status'] == "a"){
			$approve_request = "UPDATE jobs SET status = 1 WHERE id = " . $_GET['job_id'] . "";

			if ($conn->query($approve_request) === FALSE) {
				echo "Error: " . $approve_request . "<br>" . $conn->error;
			}
		} else {
			$reject_request = "UPDATE jobs SET status = 0 WHERE id = " . $_GET['job_id'] . "";
		
				
			if ($conn->query($reject_request) === FALSE) {
				echo "Error: " . $delete_request . "<br>" . $conn->error;
			}
		}
	}

	$order = 'date_posted DESC';
	if(isset($_GET['drop_down_menu']) && $_GET["drop_down_menu"] == 2){
		$order = 'title ASC';
	}

	$search = '';
	if(!empty($_GET['search'])){
		$search = $_GET['search'];
	}

	if (!empty($_GET['drop_down_menu'])) {
		$menu_value = $_GET['drop_down_menu'];
	} else {
		$menu_value = 1;
	}

	$request = "SELECT *, jobs.id AS 'main_id', DATEDIFF(CURDATE(), jobs.date_posted) AS 'date' 
		FROM jobs 
		LEFT JOIN users ON jobs.user_id = users.id
		HAVING title LIKE '%" . $search . "%'
		ORDER BY " . $order . "";
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
						<div  style="display:inline-flex;" class="secondary-container">
							<div class="flex-container centered-vertically">
								<form>
									<div style="display:inline-flex;" class="search-form-wrapper">
										<div class="search-form-field"> 
											<input class="search-form-input" type="text" value="<?php if (isset($_GET['search'])) echo $_GET['search'];?>" placeholder="Search…" name="search" > 
										</div> 
									</div>
									<div style="display:inline-flex;" class="filter-wrapper">
										<div class="filter-field-wrapper">
											<select name="drop_down_menu">
												<option value="1" <?php if ($menu_value == 1) echo 'selected="selected"'; ?>>Date</option>
												<option value="2" <?php if ($menu_value == 2) echo 'selected="selected"'; ?>>Alphabetically</option>
											</select>
										</div>
									</div>
									<div style="display: inline-flex; margin-left: -10px;" class="button-wrapper">
										<form method="post">
											<button class="button" type="submit">Submit</button>
										</form>
									</div>
								</form>
							</div>
						</div>
					</div>
						<?php pagination($request); ?>
				</div>
			</section>
		</main>
	</div>
	<?php include 'footer.php';?>
</body>
</html>