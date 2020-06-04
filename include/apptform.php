<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="format-detection" content="telephone=no">
	<link rel="stylesheet" href="../styles/apptform.scss">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<?php
$email_to = "info@orovilledentist.com";
$email_subject = "Contact Me!";
$nameErr = $phoneErr = $emailErr = $cPatChkErr = $apptTypeErr = "";
$name = $phone = $email = $cPatChk = $timeChoose = $contactTimeChoose = $dayChoose = $apptDayChoose = $apptTimeChoose = $apptType = "";
$err = FALSE;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	if (empty($_POST["name"])) {
		$nameErr = "<font color='red'><br>Please enter your name<br><br></font>";
		$err = TRUE;
	} else {
		$name = test_input($_POST["name"]);
	}
	if (empty($_POST["phone"])) {
		$phoneErr = "<font color='red'><br>Please enter a number we can contact you at<br><br></font>";
		$err = TRUE;
	} else {
		$phone = test_input($_POST["phone"]);
	}
	if (empty($_POST["email"])) {
		$emailErr = "<font color='red'><br>Please enter your email address<br><br></font>";
		$err = TRUE;
	} else {
		$email = test_input($_POST["email"]);
	}
	if (empty($_POST["cPatChk"])) {
		$cPatChkErr = "<font color='red'><br>Please specify if you are a current patient or not<br><br></font>";
		$err = TRUE;
	} else {
		$cPatChk = $_POST["cPatChk"];
	}
	if ($_POST["timeChoose"] == "AnyTime") {
		$timeChoose = "Any Time";
	} else {
		$timeChoose = implode(", ", $_POST["contactTimeChoose"]);
	}
	if ($_POST["dayChoose"] == 'Any Weekday') {
		$dayChoose = "Any Weekday";
	} else {
		$dayChoose = implode(", ", $_POST["apptDayChoose"]);
	}
	if (isset($apptTimeChoose)) {
		$apptTimeChoose = implode(" or ", $_POST["apptTimeChoose"]);
	}
	else {
		$apptTimeChoose = "Not specified";
	}
	if (empty($_POST["apptType"])) {
		$apptTypeErr = "<font color='red'><br>Please select the type of appointment you are requesting<br><br></font>";
		$err = TRUE;
	} else {
		$apptType = $_POST["apptType"];
	}
}

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && $err == FALSE) {
 	$email_message .= "Name: ".$name."\n";
 	$email_message .= "Phone: ".$phone."\n";
 	$email_message .= "Email: ".$email."\n";
 	$email_message .= "Current Patient: ".$cPatChk."\n";
 	$email_message .= "Contact Times: ".$timeChoose."\n";
 	$email_message .= "Preferred Appointment Day(s): ".$dayChoose."\n";
 	$email_message .= "Preferred Appointment Timeframe: ".$apptTimeChoose."\n";
 	$email_message .= "Appointment Type: ".$apptType."\n";

 	$headers = "From: ".$email_from."\r\n".
 	"Reply-to: ".$email_from."\r\n" .
 	"X-Mailer: PHP/" . phpversion();
 	// @mail($email_to, $email_subject, $email_message, $headers);
 	$url = 'http://itserver/webform_mailer/webformmailer.php';
 	$post_vars = "emailto=".$email_to."&emailsubject=".$email_subject."&emailmessage=".$email_message."&headers=".$headers;
 	$curl = curl_init($url);
 	curl_setopt($curl, CURLOPT_POST, 1);
 	curl_setopt($curl, CURLOPT_POSTFIELDS, $post_vars);
 	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
 	curl_setopt($curl, CURLOPT_HEADER, 0);
 	curl_setopt($curl, CURL_RETURNTRANSFER, 1);

 	$response = curl_exec($curl);
}
?>
		<div id="appointments" style="display: flex; flex-wrap:wrap; justify-content: center;width:99%;">
			<div id="apptformcont">
					<form action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' id="formContainer" method="post">
						<div id="apptText">
							<span style="font-size:2em;margin-top:-15vh;font-weight:"> Request an Appointment </span>
							<p style="margin-left:15%;margin-right:15%;font-size:1.25em;"> Fill out the adjacent form to request an appointment online.<br><br> One of our associates will contact you to schedule an appointment during the timeframe given. <br><br>Thank you for your interest and if there is anything we can do please feel free to contact us directly.
							</p>
						</div>
						<div id="apptForm">
							<img id="OGD_Logo" src="../images/ogd/OGD_Logo_Green_Big.png" alt="" style="align-self:center;margin-bottom:2vh;">
							<div style="width:100%">
								<label for="name" style=""><b>Full Name </b><br></label>
								<input type="text" id="nm" name="name" placeholder="Your name..." style="width:80%;">
								<span clas="error"> <?php echo $nameErr;?></span>
							</div>
							<div style="width:100%">
								<label for="" style="text-align:center"><br><b>Phone # </b><br></label>
								<input type="text" id="pn" name="phone" placeholder="(XXX)XXX-XXXX" style="width:80%;">
								<span clas="error"> <?php echo $phoneErr;?></span>
							</div>
							<div style="width:100%">
								<label for="" style="text-align:center"><br><b>Email </b><br></label>
								<input type="text" id="em" name="email" placeholder="blank@example.com" style="width:80%;">
								<span clas="error"> <?php echo $emailErr;?></span>
							</div>
							<div style="width:100%;padding-top:1vh;">
								<p>Have you had an appointment with us before?</p>
								<input type="radio" id="cPChkY" name="cPatChk" class="hiddenRadio" value="Yes">
								<input type="radio" id="cPChkN" name="cPatChk" class="hiddenRadio" value="No">
									<label for="cPChkY" id="cPChkYLabel" class="apptFormRadioLabel">Yes</label>
									<label for="cPChkN" id="cPChkNLabel" class="apptFormRadioLabel">No</label>
								<span clas="error"> <?php echo $cPatChkErr;?></span>
							</div>
							<div style="width:100%;">
								<p style="width:100%;text-align:center;">When is the best time(s) for us to contact you?</p>
								<input type="radio" id="AnyTime" name="timeChoose" class="hiddenRadio" value="AnyTime" checked>
								<input type="radio" id="ChooseTime" name="timeChoose" class="hiddenRadio">
								<input type="checkbox" id="Mornings" name="contactTimeChoose[]" value="Mornings" class="hiddenRadio">
								<input type="checkbox" id="Afternoons" name="contactTimeChoose[]" value="Afternoons" class="hiddenRadio">
								<input type="checkbox" id="Evenings" name="contactTimeChoose[]" value="Evenings" class="hiddenRadio">
									<label for="AnyTime" class="apptFormRadioLabel" id="anyTimeLabel">Any Time</label>
									<label for="ChooseTime" class="apptFormRadioLabel" id="chooseTimeLabel">Specific Times</label>
									<div id="apptTimeHide">
										<label for="Mornings" class="apptFormRadioLabel" id="morningsLabel">Mornings</label>
										<label for="Afternoons" class="apptFormRadioLabel" id="afternoonsLabel">Afternoons</label>
										<label for="Evenings" class="apptFormRadioLabel" id="eveningsLabel">Evenings</label>
									</div>
							</div>
							<div style="width:100%;">
								<p style="width:100%;text-align:center;">Do you have a preferred day(s) for your appointment?</p>
								<input type="radio" id="AnyDay" name="dayChoose" class="hiddenRadio" value="Any Weekday" checked>
								<input type="radio" id="ChooseDay" name="dayChoose" class="hiddenRadio">
								<input type="checkbox" id="Mondays" name="apptDayChoose[]" class="hiddenRadio" value="Mondays">
								<input type="checkbox" id="Tuesdays" name="apptDayChoose[]" class="hiddenRadio" value="Tuesdays">
								<input type="checkbox" id="Wednesdays" name="apptDayChoose[]" class="hiddenRadio" value="Wednesdays">
								<input type="checkbox" id="Thursdays" name="apptDayChoose[]" class="hiddenRadio" value="Thursdays">
								<input type="checkbox" id="Fridays" name="apptDayChoose[]" class="hiddenRadio" value="Fridays">
									<label for="AnyDay" class="apptFormRadioLabel" id="anyDayLabel">Any Day</label>
									<label for="ChooseDay" class="apptFormRadioLabel" id="chooseDayLabel">Specific Days</label>
									<div id="apptDayHide">
										<br><br>
										<label for="Mondays" class="apptFormRadioLabel" id="mondaysLabel">Mondays</label>
										<label for="Tuesdays" class="apptFormRadioLabel" id="tuesdaysLabel">Tuesdays</label>
										<label for="Wednesdays" class="apptFormRadioLabel" id="wednesdaysLabel">Wednesdays</label>
										<label for="Thursdays" class="apptFormRadioLabel" id="thursdaysLabel">Thursdays</label>
										<label for="Fridays" class="apptFormRadioLabel" id="fridaysLabel">Fridays</label>
									</div>
							</div>
							<div style="width:100%;">
								<p style="width:100%;text-align:center;">Do you have a preferred time(s) for your appointment?</p>
								<input type="checkbox" id="ApptMornings" name="apptTimeChoose[]" class="hiddenRadio" value="Mornings">
								<input type="checkbox" id="ApptAfternoons" name="apptTimeChoose[]" class="hiddenRadio" value="Afternoons">
									<label for="ApptMornings" class="apptFormRadioLabel" id="apptMorningsLabel">Mornings</label>
									<label for="ApptAfternoons" class="apptFormRadioLabel" id="apptAfternoonsLabel">Afternoons</label>
							</div>

							<div style="width:100%;">
								<p style="width:100%;text-align:center;">What type of appointment are you requesting?</p>
								<input type="radio" id="Cleaning" name="apptType" class="hiddenRadio" value="Cleaning">
								<input type="radio" id="Check-up" name="apptType" class="hiddenRadio" value="Check-up">
								<input type="radio" id="Consultation" name="apptType" class="hiddenRadio" value="Consultation">
									<label for="Cleaning" class="apptFormRadioLabel" id="cleaningLabel">Cleaning</label>
									<label for="Check-up" class="apptFormRadioLabel" id="check-upLabel">Check-up</label>
									<label for="Consultation" class="apptFormRadioLabel" id="consultationLabel">Consultation</label>
									<span clas="error"> <?php echo $apptTypeErr;?></span>
							</div>

							<?php
								if ($_SERVER["REQUEST_METHOD"] == "POST" && $err == FALSE) {
									echo "<p><br>Thank you for contacting us! Your appointment request has been completed successfully and you should be recieving a call from one of our associates soon.</p>";
								}
								else {
									echo '<input type="submit" name="submit" value="Submit" style="font-size:2em;grid-column:1/span 2;margin-left:30%;margin-right:30%;margin-top:2vh;">';
								}
								?>
						</div>
					</form>
			</div>
		</div>
</html>
