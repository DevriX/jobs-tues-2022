<!DOCTYPE html>
<html lang="en">

<?php include 'header.php';?>

<?php
	$data = array();
	$err = array();

	function print_error($error){
		echo $error;
	}

	if($_SERVER["REQUEST_METHOD"] == "POST"){
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

		$sql_request = "INSERT INTO jobs(user_id, title, status, description, salary, date_posted, location) VALUES(1, '" . $data['job_title'] . "' , 0, '" . $data['description'] . "' , " . $data['salary'] . " , CURRENT_TIMESTAMP(), '" . $data["location"] . "') ";
		

		if(empty($err)){
			$sql_request = "INSERT INTO jobs(user_id, title, status, description, salary, date_posted, location) VALUES(1, '" . $data['job_title'] . "' , 0, '" . $data['description'] . "' , " . $data['salary'] . " , CURRENT_TIMESTAMP(), '" . $data["location"] . "') ";

			if ($conn->query($sql_request) === TRUE) {
				echo "Your job was added successfully.";
			} else {
				echo "Error: " . $sql_request . "<br>" . $conn->error;
			}
		}
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
					</div>
				</div>
			</section>	
		</main>

	</div>

	<?php include 'footer.php';?>
</body>
</html>