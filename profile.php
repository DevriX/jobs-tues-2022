<!DOCTYPE html>
<html lang="en">

<body>
<?php include 'header.php'; include 'classes/users.php';
	$sql = "SELECT * FROM users WHERE $user_id = users.id";
	$result = mysqli_query($conn, $sql);

	if ($result->num_rows > 0) {
		// output data of each row
		$row = $result->fetch_assoc();
		if(empty($row)){
			echo "0 results";
		}
	}
	$change = false;

	$err = array(
		'first_name_err' => "",
		'last_name_err' => "",
		'password_err' => "",
		'email_err' => "",
		'repeat_err' => "",
		'phone_err' => "",
		'site_err' => ""
	);

	$user_data = array(
		'id'			=> $row["id"],
		'first_name' 	=> $row["first_name"],
		'last_name'  	=> $row["last_name"],
		'email'		 	=> $row["email"],
		'password'	 	=> $row["password"],
		'repeat'		=> $row["password"],
		'phone'	     	=> "",
		'company_name'  => "",
		'company_site'  => "",
		'description'   => "",
		'company_image' => "",
		'is_admin'		=> false
	);
	if(isset($row["phone_number"]) && isset($_POST["phone"])){
		$user_data["phone"] = $row["phone_number"];
		if($user_data["phone"] != $_POST["phone"]){
			$user_data["phone"] != $_POST["phone"];
			$change = true;
		}
	}
	if(isset($row["company_name"]) && isset($_POST["company_name"])){
		$user_data["company_name"] = $row["company_name"];
		if($user_data["company_name"] != $_POST["company_name"]){
			$user_data["company_name"] != $_POST["company_name"];
			$change = true;
		}
	}
	if(isset($row["company_site"]) && isset($_POST["company_site"])){
		$user_data["company_site"] = $row["company_site"];
		if($user_data["company_site"] != $_POST["company_site"]){
			$user_data["company_site"] != $_POST["company_site"];
			$change = true;
		}
	}
	if(isset($row["description"]) && isset($_POST["description"])){
		$user_data["description"] = $row["description"];
		if($user_data["description"] != $_POST["description"]){
			$user_data["description"] != $_POST["description"];
			$change = true;
		}
	}
	if(isset($row["repeat"])){
		$user_data["repeat"] = $row["repeat"];
		if(!empty($work_data["password"]) && !empty($work_data["repeat"] && $work_data["password"] != $work_data["repeat"])){
			$err["password_err"] = "passwords do not match!";
			$clear = false;
		}
	}
	/*if(isset($row["company_image"])){
		$user_data["company_image"] = $row["company_image"];
		if($user_data["company_image"] != $_POST["company_image"]){
			$user_data["company_image"] != $_POST["company_image"];
			$change = true;
		}
	}*/
	if(isset($user_data["first_name"]) && isset($_POST["first_name"])){
		if(strcmp($user_data["first_name"], $_POST["first_name"]) !== 0){
			$user_data["first_name"] = $_POST["first_name"];
			$change = true;
		}
	}
	if(isset($user_data["last_name"]) && isset($_POST["last_name"])){
		if($user_data["last_name"] != $_POST["last_name"]){
			$user_data["last_name"] != $_POST["last_name"];
			$change = true;
		}
	}
	if(isset($user_data["email"]) && isset($_POST["email"])){
		if($user_data["email"] != $_POST["email"]){
			$user_data["email"] != $_POST["email"];
			$change = true;
		}
	}
	
	if($change == true){
		
		$user = new User($user_data);
		$work_data = $user->clear_data($user_data);
		$err = $work_data['errors'];
		$is_clear = $work_data["is_clear"];
		if($is_clear){
			$user->update($conn);
		}
	}
	
	if(isset($_POST["password"]) && isset($row["password"])){
		if(isset($_POST["repeat"])){
			if(password_verify($_POST["password"], $row["password"])){
				$user = new User($user_data);
				$err["repeat_err"] = $user->update_password($conn, $_POST["repeat"]);
			}else{
				$err["password_err"] = "passwords do not match!";
			}
		}else{
			$err["repeat_err"] = "enter new password!";
		}
	}


?>
	<div class="site-wrapper">
		
		<main class="site-main">
			<section class="section-fullwidth">
				<div class="row">	
					<div class="flex-container centered-vertically centered-horizontally">
						<div class="form-box box-shadow">
							<div class="section-heading">
								<h2 class="heading-title">My Profile</h2>
							</div>
							<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
								<div class="flex-container justified-horizontally">
									<div class="primary-container">
										<h4 class="form-title">About me</h4>
										<div class="form-field-wrapper">
											<input type="text" name='first_name' id='first_name' value="<?php echo htmlspecialchars($row["first_name"]);?>" placeholder="First Name*"/>
											<span class="error">  <?php echo $err["first_name_err"];?> </span>
										</div>
										<div class="form-field-wrapper">
											<input type="text" name='last_name' id='last_name' value="<?php echo htmlspecialchars($row["last_name"]);?>" placeholder="Last Name*"/>
											<span class="error">  <?php echo $err["last_name_err"];?> </span>
										</div>
										<div class="form-field-wrapper">
											<input type="text" name='email' id='email' value="<?php echo htmlspecialchars($row["email"]);?>" placeholder="Email*"/>
											<span class="error">  <?php echo $err["email_err"];?> </span>
										</div>
										<div class="form-field-wrapper">
											<input type="text" name='password' id='password'  placeholder="Current Password"/>
											<span class="error">  <?php echo $err["password_err"];?> </span>
										</div>
										<div class="form-field-wrapper">
											<input type="text" name='repeat' id='repeat' placeholder="New Password"/>
											<span class="error">  <?php echo $err["repeat_err"];?> </span>
										</div>
										<div class="form-field-wrapper">
											<input type="text" name='phone' id='phone' value="<?php echo htmlspecialchars($row["phone_number"]);?>" placeholder="Phone Number"/>
											<span class="error">  <?php echo $err["phone_err"];?> </span>
										</div>
									</div>
									<div class="secondary-container">
										<h4 class="form-title">My Company</h4>
										<div class="form-field-wrapper">
											<input type="text" name='company_name' id='company_name' value="<?php echo htmlspecialchars($row["company_name"]);?>" placeholder="Company Name"/>
										</div>
										<div class="form-field-wrapper">
											<input type="text" name='company_site' id='company_site' value="<?php echo htmlspecialchars($row["company_site"]);?>" placeholder="Company Site"/>
											<span class="error">  <?php echo $err["site_err"];?> </span>
										</div>
										<div class="form-field-wrapper">
											<textarea id="description" name="description" placeholder="Description"><?php echo htmlspecialchars($row["company_description"]);?></textarea>
										</div>
									</div>		
								</div>					
								<button class="button">
									Save
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