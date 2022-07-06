<!DOCTYPE html>
<html lang="en">

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
										<span class="error">  <?php //echo $err["first_name_err"];?> </span>  
									</div>
									<div class="form-field-wrapper width-medium">
										<input type="text" name="lastname" placeholder="Last Name*"/>
										<span class="error">  <?php //echo $err["last_name_err"];?> </span>  
									</div>
									<div class="form-field-wrapper width-medium">
										<input type="text" name="email" placeholder="Email*"/>
										<span class="error">  <?php //echo $err["email_err"];?> </span>  
									</div>
									<div class="form-field-wrapper width-medium">
										<input type="text" name="phone" placeholder="Phone Number"/>
										<span class="error">  <?php //echo $err["phone_err"];?> </span> 
									</div>			
									<div class="form-field-wrapper width-large">
									<span class="error" >  <?php //echo $err["message_err"];?> </span>  
										<textarea placeholder="Custom Message*" name="message"></textarea>
									</div>
									<div class="form-field-wrapper width-large">
										<input type="file" name="file_input"/>
										<span class="error" >  <?php //echo $err["file_err"];?> </span> 
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