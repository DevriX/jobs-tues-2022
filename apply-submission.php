<!DOCTYPE html>
<html lang="en">

<?php 
	$data = array(
		"firstname" => "",
		"lastname"  => "",
		"email"     => "",
		"phone"     => "",
		"message"   => "",
		"file"      => ""
	);

	$err = array(
		"first_name_err" => "",
		"last_name_err"  => "",
		"email_err"      => "",
		"phone_err"      => "",
		"message_err"    => "",
		"file_err"       => ""
	);

	$allowed_extensions = array("pdf", "docx");

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		if(empty($_POST["firstname"])){
			$err["first_name_err"] = "First name is required.";
		}
		else{
			$data["firstname"] = $_POST["firstname"];
			echo $data["firstname"];
		}

		if(empty($_POST["lastname"])){
			$err["last_name_err"] = "Last name is required.";
		}
		else{
			$data["lastname"] = $_POST["lastname"];
			echo $data["lastname"];
		}

		if(empty($_POST["email"])){
			$err["email_err"] = "Email is required.";
		}
		else{
			$data["email"] = $_POST["email"];
			if(filter_var($data["email"], FILTER_VALIDATE_EMAIL) == true){
				echo $data["email"];
			}
			else{
				$err["email_err"] = "Invalid email.";
			}
		}

		if(!empty($_POST["phone"])){
			$data["phone"] = $_POST["phone"];
			if(preg_match('/^[0-9]{10}+$/', $data["phone"])) {
				echo $data["phone"];
			} else {
				$err["phone_err"] = "Invalid phone number.";
			}
		}

		if(empty($_POST["message"])){
			$err["message_err"] = "Message is required.";
		}
		else{
			$data["message"] = $_POST["message"];
			echo $data["message"];
		}

		if(isset($_FILES["file_input"])){
			$err["file_err"] = "File is required.";
		}
		else{
			//$data["file"] = $_FILES["file_input"]["name"]; //fix this, it gives an error
			//$current_extension = pathinfo($data["file"], PATHINFO_EXTENSION);
			// if(!in_array($current_extension, $allowed_extensions)){
			// 	$err["file_err"] = "Forbidden file extension.";
			// }
		}
	}

	// get job_id from $_SESSION when add job is done 
	$sql_request = "INSERT INTO applications(user_id, job_id, custom_message, cv) VALUES()"
?>

<body>
	<?php 
		include 'header.php';
	?>
	<div class="site-wrapper">

		<main class="site-main">
			<section class="section-fullwidth">
				<div class="row">	
					<div class="flex-container centered-vertically centered-horizontally">
						<div class="form-box box-shadow">
							<div class="section-heading">
								<h2 class="heading-title">Submit application to
									Company Name</h2>
							</div>
							<form method="post" action="">
								<div class="flex-container justified-horizontally flex-wrap">									
									<div class="form-field-wrapper width-medium">
										<input type="text" name="firstname" placeholder="First Name*"/>
										<span class="error">  <?php echo $err["first_name_err"];?> </span>  
									</div>
									<div class="form-field-wrapper width-medium">
										<input type="text" name="lastname" placeholder="Last Name*"/>
										<span class="error">  <?php echo $err["last_name_err"];?> </span>  
									</div>
									<div class="form-field-wrapper width-medium">
										<input type="text" name="email" placeholder="Email*"/>
										<span class="error">  <?php echo $err["email_err"];?> </span>  
									</div>
									<div class="form-field-wrapper width-medium">
										<input type="text" name="phone" placeholder="Phone Number"/>
										<span class="error">  <?php echo $err["phone_err"];?> </span> 
									</div>			
									<div class="form-field-wrapper width-large">
									<span class="error" >  <?php echo $err["message_err"];?> </span>  
										<textarea placeholder="Custom Message*" name="message"></textarea>
									</div>
									<div class="form-field-wrapper width-large">
										<input type="file" name="file_input"/>
										<span class="error" >  <?php echo $err["file_err"];?> </span> 
									</div>
								</div>	
								<button class="button">
									Submit
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