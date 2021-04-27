<!DOCTYPE html>
<html>
<head>
	<title>MD5 Password Cracker</title>
</head>
<body>

	<h1>Hash-o-matic MD5 Password Cracker</h1>
	<p>This application takes an MD5 hash ID a four digit PIN and checks all 10,000 possible four digit PIN's to determine the PIN.</p>

	<?php 
		include "maker.php";

		$pin = "Not found";
		$show = 15;

		//data handling if form submission was executed
		if (isset($_GET["md5"])) {
			// start timer if submit button was clicked
			$startTime = microtime(TRUE);
			$formInput = $_GET["md5"];

			//handle form submitted without data
			if ($formInput == "") {
				print "<br>Sumbitted Value: No value entered";
				print "<br>PIN: $pin";
			} else {//handle form submitted with data
				print "<br>Sumbitted Value: $formInput";
				print "<br>Debug Output:";

				$check = 0;

				// loop through all 4 digits PINs
				while ($check < 10000) {
					// ensure we append 0's to 1,2,3 digit PIN variations
					if ($check <= 9) {
						$check = "000" . $check;
					} elseif ($check <= 99) {
						$check = "00" . $check;
					} elseif ($check <= 999) {
						$check = "0" . $check;
					}

					$hashedNumber = hash("md5", $check);

					// print the first 15 hashes we try
					if ($show > 0) {
						print "<br>$hashedNumber $check \n";

						$show = $show - 1;
					}

					// print needed if matching hash was found
					if ($hashedNumber == $formInput) {
						$pin = $check;

						print "<br>Total Checks: " . (intval($check) + 1);

						$endTime = microtime(TRUE);

						$totalTime = $endTime - $startTime;

						print "<br>Total Time: $totalTime";
						print "<br>PIN: $pin";

						print "<p style='width:50%;'>If the Total Time shows something like '3.6001205444336<b>E-5</b>' this translates as 0.0000036001 microseconds(I believe). The 'E-5' is an extremely accurate representation of the <i>float</i> data type and you can see an example if you try running the MD5 hash for 0000.</p>";
						break;
					}

					$check = $check + 1;

				}

				// handle data if no matching hash was found
				if ($check == 10000) {
					print "<br>PIN: $pin";
				}			

			}			
			
		} else { //data handling if form submission was NOT executed
			print "<br>PIN: $pin";
		}
	?>

	<form>
		<input type="text" name="md5" size="40">
		<input type="submit" value="Crack MD5">
	</form>	

	<p><a href="index.php">Reset this page</a></p>
</body>
</html>