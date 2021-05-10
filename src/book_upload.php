<?php 
	// TODO HANDLE POST REQUEST
?>


<!DOCTYPE html>
<html>
	<?php require('template/header.php'); ?>

		<div class=" brand-dark" style="padding: 150px 7%;">
			<form action="book_upload.php" method="POST">
				<div class="row">
					<div class="col s3">
						<img src="../image/cover_placeholder.png" style="margin: 5px; margin-top:20px;" width="127" height="145">

						
						<div class="file-field input-field" style="margin-left: 15%;">
							<div class="btn brand-btn">
							<span>Upload</span>
							<input type="file">
							</div>
							<div class="file-path-wrapper">
							<input class="file-path validate" type="text">
							</div>
						</div>
					
					</div>


					<div class="col s9" style="background: #AAD5FF">

						<div class="col s6">
						<input type="text" style="float: left; margin-top: 15px; padding: 10px; width: 100%; height: 40%; background-color:#7fa1bf; border-color: white;" class="z-depth-0 text brand-anan" placeholder="Book Title">
						<input type="text" style="float: left; margin-top: 15px; padding: 10px; width: 100%; height: 40%; background-color:#7fa1bf; border-color: white;" class="z-depth-0 text" placeholder="Author">
						<input type="text" style="float: left; margin-top: 15px; padding: 10px; width: 100%; height: 40%; background-color:#7fa1bf; border-color: white;" class="z-depth-0 text" placeholder="Description">
	
						<div class="col s12">
							<div class="col s6" > 
								<input type="text" style="font-size: 14px; float: left; margin-top: 15px; padding: 10px; width: 50%; height: 40%; background-color:#7fa1bf; border-color: white;" class="z-depth-0 text" placeholder="Page count">	
							</div>
							<div class="col s6" >
								<input type="text" style="font-size: 14px; float: left; margin-top: 15px; padding: 10px; width: 50%; height: 40%; background-color:#7fa1bf; border-color: white;" class="z-depth-0 text" placeholder="Published year">	

							</div>
						</div>
						
						<input type="text" style="font-size: 14px; float: left; margin-top: 15px; padding: 10px; width: 40%; height: 40%; background-color:#7fa1bf; border-color: white;" class="z-depth-0 text" placeholder="ISBN">	

						<input type="month" style="float: right; margin-top: 15px; padding: 10px; width: 55%; height: 40%; background-color:#7fa1bf; border-color: white;" class="z-depth-0 text" placeholder="Enter Date">
						
						</div>
						
						<div class="col s6">
							<div class="input-field col s12">
							<select multiple>
								<option value="" disabled selected>Choose your option</option>
								<!-- PULL FROM DB GENRES PHP -->
								<option value="1">Option 1</option>
								<option value="2">Option 2</option>
								<option value="3">Option 3</option>
							</select>
							<label>Genres</label>
  						</div>

						



				</div>
				
				<div class="row s6">
					<div class="input-field col s12">
						<?php require('template/language_picker.php'); ?>
					</div>
			
				</div>
			</form>

		</div>
	
		<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
		
		<script>
			$(document).ready(function(){
				$('select').formSelect();
			});
		</script>
	</body>
</html>