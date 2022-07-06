<!DOCTYPE html>
<html lang="en">

<body>
<?php include 'header.php';
	


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
											<input type="text" name="name" id="name" placeholder="First Name*"/>
										</div>
										<div class="form-field-wrapper">
											<input type="text" name="lastName" id="LastName" placeholder="Last Name*"/>
										</div>
										<div class="form-field-wrapper">
											<input type="text" name="email" id="email" placeholder="Email*"/>
										</div>
										<div class="form-field-wrapper">
											<input type="text" name="password" id="password" placeholder="Password*"/>
										</div>
										<div class="form-field-wrapper">
											<input type="text" name="repeatPassword" id="repeatPassword" placeholder="Repeat Password*"/>
										</div>
										<div class="form-field-wrapper">
											<input type="text" name="phoneNumber" id="phoneNumber" placeholder="Phone Number"/>
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