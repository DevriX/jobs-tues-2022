<!DOCTYPE html>
<html lang="en">

<?php include 'header.php';?>

<?php
	$data = array();
	$err = array();

	function print_error($error){
		echo $error;
	}


	if($_SERVER["REQUEST_METHOD"] == "GET"){
		if(!empty($_GET['edit_job'])){
			$edit = $_GET['edit_job'];
			// $edit_request = $conn->query("SELECT * FROM jobs WHERE id=" . $_GET["edit_job"] . " ");
			// $row = mysqli_fetch_array($edit_request, MYSQLI_BOTH);
		}
	}

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		if(empty($_GET['edit_job'])){
			if(empty($_POST["job_title"])){
				$err["job_title_err"] = "Job title is required.";
			} else {
				$data["job_title"] = $_POST["job_title"];
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

			if(empty($err)){
				$sql_request = "INSERT INTO jobs(user_id, title, status, description, salary, date_posted, location) VALUES(1, '" . $data['job_title'] . "' , 0, '" . $data['description'] . "' , " . $data['salary'] . " , CURRENT_TIMESTAMP(), '" . $data["location"] . "') ";

				if ($conn->query($sql_request) === TRUE) {
					echo "Your job was added successfully.";
				} else {
					echo "Error: " . $sql_request . "<br>" . $conn->error;
				}
			}
		} else {
				$edit_request = $conn->query("SELECT * FROM jobs WHERE id=" . $_GET["edit_job"] . " ");
				$row = mysqli_fetch_array($edit_request, MYSQLI_BOTH);

				$edit_data = array(
					'new_title'       => $row['title'],
					'new_location'    => $row['location'],
					'new_salary'      => $row['salary'],
					'new_description' => $row['description']
				);

				if(!empty($_POST['edit_title'])) $edit_data['new_title'] = $_POST['edit_title'];
				if(!empty($_POST['edit_location'])) $edit_data['new_location'] = $_POST['edit_location'];
				if(!empty($_POST['edit_salary'])) $edit_data['new_salary'] = $_POST['edit_salary'];
				if(!empty($_POST['edit_description'])) $edit_data['new_description'] = $_POST['edit_description'];

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
			//}
		}
	}

?>

<body>
	<div class="site-wrapper">

		<main class="site-main">
			<section class="section-fullwidth">
				<div class="row">	
					<div class="flex-container centered-vertically centered-horizontally">
						<?php if(empty($_GET['edit_job'])){ ?>
						<div class="form-box box-shadow">
							<div class="section-heading">
								<h2 class="heading-title">New job</h2>
							</div>
							<form method="post" action="">
								<div class="flex-container flex-wrap">
									<div class="form-field-wrapper width-large">
										<input type="text" name="job_title" placeholder="Job title*"/>
										<span class="error">  <?php 
										if(!empty($err["job_title_err"]))
											(print_error($err["job_title_err"]))
											?> </span>
									</div>
									<div class="form-field-wrapper width-large">
										<input type="text" name="location" placeholder="Location"/>
									</div>
									<div class="form-field-wrapper width-large">
										<input type="number" name="salary" placeholder="Salary"/>
										<span class="error">  <?php if(!empty($err["salary_err"]))
											(print_error($err["salary_err"]))?> </span>
									</div>
									<div class="form-field-wrapper width-large">
										<textarea name="description" placeholder="Description*"></textarea>
										<span class="error">  <?php if(!empty($err["description_err"]))
											(print_error($err["description_err"]))?> </span>
									</div>	
								</div>
								<button type="submit" class="button">
									Create
								</button>
							</form>
						</div>
						<?php } else { 
								$display_edit = $conn->query("SELECT * FROM jobs WHERE id=" . $_GET["edit_job"] . " ");
								$display_row = mysqli_fetch_array($display_edit, MYSQLI_BOTH);
							?>
							<div class="form-box box-shadow">
							<div class="section-heading">
								<h2 class="heading-title">Edit job</h2>
							</div>
							<form method="post" action="">
								<div class="flex-container flex-wrap">
									<div class="form-field-wrapper width-large">
										<input type="text" name="edit_title" value='<?php echo $display_row['title']?>' placeholder="Job Title">
									</div>
									<div class="form-field-wrapper width-large">
										<input type="text" name="edit_location" value='<?php echo $display_row['location']?>' placeholder="Location">
									</div>
									<div class="form-field-wrapper width-large">
										<input type="number" name="edit_salary" value=<?php echo $display_row['salary']?> placeholder="Salary">
									</div>
									<div class="form-field-wrapper width-large">
										<textarea name="edit_description" placeholder="Description"><?php echo $display_row['description']?></textarea>
									</div>	
								</div>
								<button name="edit_done" type="submit" class="button">
									Submit
								</button>
							</form>

						<?php } ?>
					</div>
				</div>
			</section>	
		</main>

	</div>

	<?php include 'footer.php';?>
</body>
</html>