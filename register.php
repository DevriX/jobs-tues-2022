<!DOCTYPE html>
<html lang="en">

<body>
<?php include 'header.php'; include "classes/Users.php";




	$user = new User($_POST);
	$work_data = $user->clear_data($_POST);
	$err = $work_data['errors'];
	$is_clear = $work_data["is_clear"];
	if($is_clear){
		$user->insert($conn);
	}
	




?>
	<div class="site-wrapper">

		<main class="site-main">
			<section class="section-fullwidth">
				<div class="row">	
					<div class="flex-container centered-vertically centered-horizontally">
						<div class="form-box box-shadow">
							<div class="section-heading">
								<h2 class="heading-title">Register</h2>
							</div>
							<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
								<div class="flex-container justified-horizontally">
									<div class="primary-container">
										<h4 class="form-title">About me</h4>
										<div class="form-field-wrapper">
											<input type="text" name="first_name" id="first_name" placeholder="First Name*"/>
											<span class="error">  <?php echo $err["first_name_err"];?> </span>
										</div>
										<div class="form-field-wrapper">
											<input type="text" name="last_name" id="Last_name" placeholder="Last Name*"/>
											<span class="error">  <?php echo $err["last_name_err"];?> </span>
										</div>
										<div class="form-field-wrapper">
											<input type="text" name="email" id="email" placeholder="Email*"/>
											<span class="error">  <?php echo $err["email_err"];?> </span>
										</div>
										<div class="form-field-wrapper">
											<input type="text" name="password" id="password" placeholder="Password*"/>
											<span class="error">  <?php echo $err["password_err"];?> </span>
										</div>
										<div class="form-field-wrapper">
											<input type="text" name="repeat" id="repeat" placeholder="Repeat Password*"/>
											<span class="error">  <?php echo $err["repeat_err"];?> </span>
										</div>
										<div class="form-field-wrapper">
											<input type="text" name="phone" id="phone" placeholder="Phone Number"/>
											<span class="error">  <?php echo $err["phone_err"];?> </span>
										</div>
									</div>
									<div class="secondary-container">
										<h4 class="form-title">My Company</h4>
										<div class="form-field-wrapper">
											<input type="text" name="companyName" id="companyName" placeholder="Company Name"/>
										</div>
										<div class="form-field-wrapper">
											<input type="text" name="companySite" id="companySite" placeholder="Company Site"/>
											<span class="error">  <?php echo $err["site_err"];?> </span>
										</div>
										<div class="form-field-wrapper">
											<textarea name="description" id="description" placeholder="Description"></textarea>
										</div>
									</div>		
								</div>		
								<button class="button">
									Register
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