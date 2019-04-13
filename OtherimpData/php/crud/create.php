<html>
<head>
	<title>CRUD Using PHP PDO</title>
	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">


<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
  <!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>

	<div class="container">
		<div class="col-md-6 col-md-offset-3"><!--offset-md-3 bootstrap 4 -->

			<form name="userForm" role="form" method="POST"  action="UserController.php">

				<h3 style="margin-bottom: 25px; text-align: center;">CRUD using PHP PDO</h3>
				<div class="form-group">
					<input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
				</div>
				<div class="form-group">
					<input type="text" class="form-control" id="email" name="email" placeholder="Email" required>
				</div>
				<div class="form-group">
					<input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile Number" required>
				</div>
				<div class="form-group">
					<label for="gender">Select Gender</label>
					<select class="form-control" id="gender" name="gender">
						<option>--Select--</option>
						<option>Male</option>
						<option>Female</option>

					</select>
				</div>
				<div class="form-group">
					<label for="hobby">Select Hobbies</label>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="checkbox" name="hobby[]" id="hobby" value="cricket">
						<label class="form-check-label" for="hobby">Cricket</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="checkbox" name="hobby[]"  id="hobby" value="football">
						<label class="form-check-label" for="hobby">Football</label>
					</div>
				</div>

				<div class="form-group">
					<label for="isDisable">Are you Disable</label>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="disable" id="disable" value="yes">
						<label class="form-check-label" for="disable">Yes</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="disable" id="disable" value="no">
						<label class="form-check-label" for="disable">No</label>
					</div>
				</div>
				<div class="form-group">
					<textarea class="form-control" type="textarea" id="description" name="description" placeholder="Please describe yourself here..." maxlength="140" rows="7"></textarea>

				</div>

				<button type="submit" id="submit"  name="create" class="btn btn-primary pull-right">Submit Form</button>
			</form>

		</div>


	</div>

</body>
</html>