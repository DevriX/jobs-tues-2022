<!DOCTYPE html>
<html lang="en">

<body>
<?php include 'header.php'; include "classes/Users.php";

$err = array(
	'first_name_err' => "",
	'last_name_err' => "",
	'password_err' => "",
	'email_err' => "",
	'repeat_err' => ""
);

if(empty($_POST["first_name"])){
	$err["first_name_err"] = "First name is reqired!";
};

if(empty($_POST["last_name"])){
	$err["last_name_err"] = "Last name is reqired!";
};

if(empty($_POST["email"])){
	$err["email_err"] = "Email is reqired!";
};


if(empty($_POST["password"])){
	$err["password_err"] = "Password is reqired!";
};

if(empty($_POST["repeat"])){
	$err["repeat_err"] = "You have to repeat the password!";
};



$user_data = array(
	'first_name' 	=> $_POST["first_name"],
	'last_name'  	=> $_POST["last_name"],
	'email'		 	=> $_POST["email"],
	'password'	 	=> password_hash($_POST["password"], PASSWORD_DEFAULT),
	'phone'	     	=> $_POST["phone"],
	'company_name'  => $_POST["companyName"],
	'company_site'  => $_POST["companySite"],
	'description'   => $_POST["description"],
	'company_image' => "",
	'is_admin'		=> false

);

if($_POST["password"] != $_POST["repeat"] && !empty($_POST["password"]) && !empty($_POST["repeat"])){
	$err["password_err"] = "passwords do not match!";
}

if(filter_var($user_data["email"], FILTER_VALIDATE_EMAIL) != true && !empty($_POST["email"])){
	$err["email_err"] = "email is not valid!";
}
$user = new User($user_data);

$user->insert($conn);



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
										</div>
									</div>
									<div class="secondary-container">
										<h4 class="form-title">My Company</h4>
										<div class="form-field-wrapper">
											<input type="text" name="companyName" id="companyName" placeholder="Company Name"/>
										</div>
										<div class="form-field-wrapper">
											<input type="text" name="companySite" id="companySite" placeholder="Company Site"/>
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