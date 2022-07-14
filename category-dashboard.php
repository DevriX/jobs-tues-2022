<!DOCTYPE html>
<html lang="en">

<?php include 'header.php';?>

<?php
	$category_name = "";
	$category_err  = "";
	$user_id 	   = $_SESSION['id'];
	$sql 		   = "SELECT is_admin FROM users WHERE $user_id = users.id";
	$result 	   = mysqli_query($conn, $sql);

	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		if(empty($row)){
			echo "0 results";
		}
	}
	$is_admin = $row['is_admin'];
	if($row['is_admin'] == 1){
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
										<?php if($row['is_admin'] == 1){?>
											<button class="button" >Add New</button>
										<?php }; ?>
									</div>	
								</form>
							</div>
						</div>
					</div>

					<?php
					$request_category = "SELECT * FROM categories ORDER BY title ASC";
					$page_first_result = ($page-1) * RES_LIMIT;
					$num_rows = mysqli_num_rows ($conn->query($request_category));
					$page_total = ceil($num_rows / RES_LIMIT);
					$request_info = $conn->query($request_category." LIMIT " . $page_first_result . ','. RES_LIMIT);

					?> <ul class="jobs-listing"> <?php
					while($row = mysqli_fetch_array($request_info, MYSQLI_BOTH)) { ?>
						<li class="job-card">
							<div class="job-primary">
								<h2 class="job-title"><?php echo $row["title"]?></h2>
							</div>
							<div class="job-secondary centered-content">
								<div class="job-actions">
									<?php if(isset($is_admin) && $is_admin){?>
									<a href="<?php echo $_SERVER["PHP_SELF"]?>?cat_id=<?php echo $row['id']; ?>" class="button button-inline">Delete</a>
									<?php }; ?>
								</div>
								<div class="job-secondary centered-content">
									<div class="job-actions">
										<a href="<?php echo $_SERVER["PHP_SELF"]?>?cat_id=<?php echo $row['id']; ?>" class="button button-inline">Delete</a>
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