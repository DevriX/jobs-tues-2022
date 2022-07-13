<!DOCTYPE html>
<html lang="en">

<body>
<?php include 'header.php';?>

<?php
$data = array();
$categories = array();
$err = array();

function print_error($error){
	echo $error;
}

if(!empty($_POST["create_done"])){
	if(empty($_POST["title"])){
		$err["job_title_err"] = "Job title is required.";
	} else {
		$data["job_title"] = $_POST["title"];
	}

	if(!empty($_POST["location"])){
		$data["location"] = $_POST["location"];
	}

	if(!empty($_POST["salary"])){
		$data["salary"] = intval($_POST["salary"]);
		if(!is_int($data["salary"])){
			$err["salary_err"] = "Salary needs to be numeric.";
		}
	}

	if(empty($_POST["description"])){
		$err["description_err"] = "Job description is required.";
	} else {
		$data["description"] = $_POST["description"];
	}

	if(!empty($_POST['categories'])){
		foreach($_POST['categories'] as $selected) {
			array_push($categories, $selected);
		}
	}

	if(empty($err)){
		$sql_request = "INSERT INTO jobs(user_id, title, status, description, salary, date_posted, location) VALUES('1', '" . $data['job_title'] . "' , 0, '" . $data['description'] . "' , " . $data['salary'] . " , CURRENT_TIMESTAMP(), '" . $data["location"] . "') ";

		if ($conn->query($sql_request) === FALSE) {
			echo "Error: " . $sql_request . "<br>" . $conn->error;
		} else {
			$last_id = mysqli_insert_id($conn);
		}

		foreach($categories as $c) {
			$categories_request = "INSERT INTO jobs_categories(job_id, category_id) VALUES($last_id, $c)";

			if ($conn->query($categories_request) === FALSE) {
				echo "Error: " . $categories_request . "<br>" . $conn->error;
			}
		}
	}
} 
if(!empty($_POST["edit_done"])) {

		$edit_data = array();

		if(!empty($_POST['title'])) $edit_data['new_title'] = $_POST['title'];
		if(!empty($_POST['location'])) $edit_data['new_location'] = $_POST['location'];
		if(!empty($_POST['salary'])) $edit_data['new_salary'] = $_POST['salary'];
		if(!empty($_POST['description'])) $edit_data['new_description'] = $_POST['description'];



		$submit_edit_request = 
				"UPDATE jobs SET  title = '" . $edit_data['new_title'] . "',
				location = '" . $edit_data['new_location'] . "', 
				salary = " . $edit_data['new_salary'] . ", 
				description = '" . $edit_data['new_description'] . "',
				status = 0 
				WHERE id=" . $_GET["edit_job"] . " ";

		if ($conn->query($submit_edit_request) === FALSE) {
			echo "Error: " . $submit_edit_request . "<br>" . $conn->error;
		}

}
if(!empty($_GET['edit_job'])){
	$edit_request = $conn->query("SELECT * FROM jobs WHERE id=" . $_GET["edit_job"] . " ");
	$row = mysqli_fetch_array($edit_request, MYSQLI_BOTH);
}
?>

<body>
	<div class="site-wrapper">

		<main class="site-main">
			<section class="section-fullwidth">
				<div class="row">	
					<div class="flex-container centered-vertically centered-horizontally">
						<div class="form-box box-shadow">
							<div class="section-heading">
								<h2 class="heading-title">
								<?php if(empty($_GET['edit_job'])){ ?>
									New job
								<?php } else { ?>
									Edit job
								<?php } ?>
								</h2>
							</div>
							<form method="post" action="">
								<div class="flex-container flex-wrap">
									<div class="form-field-wrapper width-large">
										<input type="text" name="title" placeholder="Job title*" value="<?php if(!empty($row['title'])){ echo $row['title']; } ?>"/>
										<span class="error">  <?php 
										if(!empty($err["job_title_err"]))
											(print_error($err["job_title_err"]))
											?> </span>
									</div>
									<div class="form-field-wrapper width-large">
										<input type="text" name="location" placeholder="Location" value="<?php if(!empty($_GET['edit_job'])){ echo $row['location']; } ?>"/>
									</div>
									<div class="form-field-wrapper width-large">
										<input type="number" name="salary" placeholder="Salary" value="<?php if(!empty($_GET['edit_job'])){ echo $row['salary']; } ?>"/>
										<span class="error">  <?php if(!empty($err["salary_err"]))
											(print_error($err["salary_err"]))?> </span>
									</div>
									<div class="form-field-wrapper width-large">
										<textarea name="description" placeholder="Description*"><?php if(!empty($_GET['edit_job'])){ echo $row['description']; } ?></textarea>
										<span class="error">  <?php if(!empty($err["description_err"]))
											(print_error($err["description_err"]))?> </span>
									</div>
									<div class="filter-wrapper">
										<div class="select--multiple" placeholder="Categories">
											<select class="select" id="multi-select" name="categories[]" multiple>
												<option disabled>--Please choose a category--</option>
												<?php 
												$edit_request = $conn->query("SELECT * FROM categories");
												while($row = mysqli_fetch_array($edit_request, MYSQLI_BOTH)){
												?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['title']; ?></option>
												<?php } ?>
											</select>
											<span class="focus"></span>
										</div>
									</div>
								</div>
								<?php if(empty($_GET['edit_job'])){ ?>
								<button name="create_done" type="submit" class="button" value="create_done">
										Create
									<?php } else { ?>
								<div style="display: inline-flex;">
									<button name="edit_done" type="submit" class="button" value="edit_done">
											Submit
									</button>
								</div>
									<?php } ?>
							</form>
						</div>
					</div>
				</div>
			</section>	
		</main>

	</div>

	<?php include 'footer.php';?>
</body>
</html>