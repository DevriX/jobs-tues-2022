<!DOCTYPE html>
<html lang="en">

<body>
	<?php 
		include 'header.php';	
		$user_id = $_SESSION['id'];
		$sql = "SELECT * FROM users WHERE $user_id = users.id";
		$result = mysqli_query($conn, $sql);

		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			if(empty($row)){
				echo "0 results";
			}
		}
		
		if(!empty($_POST)){
			$job_id = $_POST['job_id'];
			$custom_message = $_POST['custom_message'];
			$sql = "INSERT into applications(user_id, job_id, custom_message) values ('$user_id', '$job_id', '$custom_message')";
			mysqli_query($conn, $sql);
		}
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
							<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
								<div class="flex-container justified-horizontally flex-wrap">									
									<div class="form-field-wrapper width-medium">
										<input type="text" name="first_name" value="<?php echo($row['first_name']) ?>" placeholder="First Name*"/>
										<span class="error">  <?php //echo $err["first_name_err"];?> </span>  
									</div>
									<div class="form-field-wrapper width-medium">
										<input type="text" name="last_name" value="<?php echo($row['last_name']) ?>" placeholder="Last Name*"/>
										<span class="error">  <?php //echo $err["last_name_err"];?> </span>  
									</div>
									<div class="form-field-wrapper width-medium">
										<input type="text" name="email" value="<?php echo($row['email']) ?>" placeholder="Email*"/>
										<span class="error">  <?php //echo $err["email_err"];?> </span>  
									</div>
									<div class="form-field-wrapper width-medium">
										<input type="text" name="phone_number" value="<?php echo($row['phone_number']) ?>" placeholder="Phone Number"/>
										<span class="error">  <?php //echo $err["phone_err"];?> </span> 
									</div>			
									<div class="form-field-wrapper width-large">
									<span class="error" >  <?php //echo $err["message_err"];?> </span>  
										<textarea placeholder="message*" name="custom_message"></textarea>
									</div>
									<div class="form-field-wrapper width-large">
										<input type="file" name="file_input"/>
										<span class="error" >  <?php //echo $err["file_err"];?> </span> 
									</div>
									<div>
										<input type="hidden" name="job_id" value=<?php if(!empty($_GET["job_id"]))echo($_GET["job_id"]) ?> />
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