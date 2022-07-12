<!DOCTYPE html>
<html lang="en">

<?php include 'header.php';?>

<?php
	$category_name = "";
	$category_err  = "";

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		if(!empty($_POST["new_category"])){
			$category_name = $_POST["new_category"];
			$sql_request = "INSERT INTO categories(title) VALUES('" . $category_name . "') ";

			if ($conn->query($sql_request) === FALSE) {
				echo "Error: " . $sql_request . "<br>" . $conn->error;
			}
		}
	}

	if($_SERVER["REQUEST_METHOD"] == "GET"){
		if(!empty($_GET['cat_id'])){
			$delete_category_id = $_GET['cat_id'];
			$delete_request = "DELETE FROM `categories` WHERE id= " . $delete_category_id . " ";
		
				
			if ($conn->query($delete_request) === FALSE) {
				echo "Error: " . $delete_request . "<br>" . $conn->error;
			}
		}
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
									<a href="dashboard.php">Jobs</a>					
								</li>
								<li class="menu-item current-menu-item">
									<a href="category-dashboard.php">Categories</a>
								</li>
							</ul>
						</div>
						<div class="secondary-container">
							<div class="form-box category-form">
								<form method="post" action="" >
									<div class="flex-container justified-vertically">									
										<div class="form-field-wrapper">
											<input type="text" name="new_category" placeholder="Enter Category Name..."/>
										</div>
										<button class="button" >Add New</button>
									</div>	
								</form>
							</div>
						</div>
					</div>

					<?php 
						$request_category = "SELECT * FROM categories ORDER BY title ASC";
						pagination($request_category); ?>
				</div>
			</section>
		</main>
	</div>
	<?php include 'footer.php';?>
</body>
</html>