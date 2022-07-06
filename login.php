<!DOCTYPE html>
<html lang="en">

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
							<form>
								<div class="form-field-wrapper">
									<input type="text" placeholder="Email"/>
								</div>
								<div class="form-field-wrapper">
									<input type="text" placeholder="Password"/>
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