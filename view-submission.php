<!DOCTYPE html>
<html lang="en">

<?php
include 'header.php';

$request_application = $conn->query("SELECT * FROM applications LEFT JOIN jobs ON applications.job_id=jobs.id LEFT JOIN users ON applications.user_id=users.id WHERE users.id=" . $_GET['user_id'] ."");

$row = mysqli_fetch_array($request_application, MYSQLI_BOTH);

?>

<body>
	<a href="view-submission.php?user_id=<?php echo $row['id']; ?>">
		<div class="site-wrapper">
			<main class="site-main">
				<section class="section-fullwidth">
					<div class="row">	
						<div class="flex-container centered-vertically centered-horizontally">
							<div class="form-box box-shadow">
								<div class="section-heading">
									<h2 class="heading-title"><?php echo "" . $row["title"] . " - " . $row["first_name"] . " " . $row["last_name"] . "" ?></h2>
								</div>
								<form>
									<div class="flex-container justified-horizontally flex-wrap">
										<div class="form-field-wrapper width-medium">
											<input type="text" placeholder="<?php echo $row["email"] ?>" readonly />
										</div>
										<div class="form-field-wrapper width-medium">
											<input type="text" placeholder="<?php echo $row["phone_number"] ?>" readonly />
										</div>			
										<div class="form-field-wrapper width-large">
											<textarea placeholder="<?php echo $row["custom_message"] ?>" readonly ></textarea>
										</div>
									</div>	
									<button type="submit" class="button">
										Download CV
									</button>
								</form>
							</div>
						</div>
					</div>
				</section>	
			</main>
		</div>
	</a>
	<?php include 'footer.php';?>
</body>
</html>