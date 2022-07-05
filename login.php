<!DOCTYPE html>
<html lang="en">

<?php 
	$erorrs = array(
		"email"    => "",
		"password" => ""
	);

	$inputs = array(
		"email"    => "",
		"password" => ""
	);

	if($_SERVER["REQUEST_METHOD"] == "POST") {
		if(empty($_POST["email"])){
			$erorrs["email"] = "Email is required!";
		}
		else{
			$inputs["email"] = $_POST["email"];
			if(filter_var($inputs["email"], FILTER_VALIDATE_EMAIL)){
				echo var_dump($inputs["email"]);
			}
			else{
				$erorrs["email"] = "Invalid email!";
			}
			
		}

		if(empty($_POST["password"])){
			$erorrs["password"] = "Password is required!";
		}
		else{
			$inputs["password"] = $_POST["password"];
			echo var_dump($inputs["password"] );
		}		
	}
?>

<body>
<?php include 'header.php';?>
	<div class="site-wrapper">

		<main class="site-main">
			<section class="section-fullwidth section-login">
				<div class="row">	
					<div class="flex-container centered-vertically centered-horizontally">
						<div class="form-box box-shadow">
							<div class="section-heading">
								<h2 class="heading-title">Login</h2>
							</div>
							<form method = "post">
								<div class="form-field-wrapper">
									<input type="text" name = "email" placeholder="Email"/>
									<span class="error">  <?php echo $erorrs["email"];?> </span>
									
								</div>
								<div class="form-field-wrapper">
									<input type="text" name = "password" placeholder="Password"/>
									<span class="error">  <?php echo $erorrs["password"];?> </span>
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