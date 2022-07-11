<!DOCTYPE html>
<html lang="en">

<body>
<?php include 'header.php';

$err = array(
	'email_err' => "",
	'password_err' => "",
	'other_err' => ""
);
//if(empty($_SESSION["id"])){
	if (isset($_POST['email']) && isset($_POST['password'])) {

		function validate($data){
	
		   $data = trim($data);
	
		   $data = stripslashes($data);
	
		   $data = htmlspecialchars($data);
	
		   return $data;
	
		}
	
		$email = validate($_POST['email']);
	
		$pass = validate($_POST['password']);
	
		if (empty($email)) {
			$err['email_err'] = "enter email";
	
		}else if(empty($pass)){
			$err['password_err'] = "enter password";
	
		}else{
			$sql = "SELECT * FROM users WHERE email='$email'";
			
			$result = mysqli_query($conn, $sql);
	
			if (mysqli_num_rows($result) === 1) {
	
				$row = mysqli_fetch_assoc($result);
				if ($row['email'] === $email && password_verify($pass, $row['password'])) {
					$_SESSION['email'] = $row['email'];
	
					$_SESSION['id'] = $row['id'];
					header("Location: index.php");
					exit();
	
				}else{
					$err['other_err'] = "Incorect email or password";
				}
	
			}else{
				$err['other_err'] = "Incorect email or password";
			}
	
		}
	}
//}


?>


	<div class="site-wrapper">

		<main class="site-main">
			<section class="section-fullwidth section-login">
				<div class="row">	
					<div class="flex-container centered-vertically centered-horizontally">
						<div class="form-box box-shadow">
							<div class="section-heading">
								<h2 class="heading-title">Login</h2>
							</div>
							<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
								<div class="form-field-wrapper">
									<input type="text" name="email" id="email" placeholder="Email"/>
									<span class="error">  <?php echo $err["email_err"];?> </span>
								</div>
								<div class="form-field-wrapper">
									<input type="text" name="password" id="password" placeholder="Password"/>
									<span class="error">  <?php echo $err["password_err"];?> </span>
								</div>
								<div>
									<span class="error">  <?php echo $err["other_err"];?> </span>
								</div>
								<button type="submit" class="button">
									Login
								</button>
							</form>
							<a href="#" class="button button-inline">Forgot Password</a>
						</div>
					</div>
				</div>
			</section>	
		</main>
	</div>
	<?php include 'footer.php';?>
</body>
</html>