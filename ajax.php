<?php

require ('database.php');

//email signup ajax call
if(isset($_GET['action'])&& $_GET['action'] == 'signup'){
	
	
	
	//sanitize data
	$email = mysql_real_escape_string($_POST['signup-email']);
	
	//validate email address - check if input was empty
	if(empty($email)){
		$status = "error";
		$message = "You did not enter an email address!";
	}
	else if(!preg_match('/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/', $email)){ //validate email address - check if is a valid email address
			$status = "error";
			$message = "You have entered an invalid email address!";
	}
	else {
		$existingSignup = mysql_query("SELECT * FROM signups WHERE signup_email_address='$email'");   
		if(mysql_num_rows($existingSignup) < 1){
			
			$date = date('Y-m-d');
			$time = date('H:i:s');
			
			$insertSignup = mysql_query("INSERT INTO signups (signup_email_address, signup_date, signup_time) VALUES ('$email','$date','$time')");
			if($insertSignup){ //if insert is successful
				$status = "success";
				$message = "You have been signed up!";	
			}
			else { //if insert fails
				$status = "error";
				$message = "Ooops, Theres been a technical error!";	
			}
		}
		else { //if already signed up
			$status = "error";
			$message = "This email address has already been registered!";
		}
	}
	
	//return json response
	$data = array(
		'status' => $status,
		'message' => $message
	);
	
	echo json_encode($data);
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ajax &amp; JSON Email Singup Form</title>

<style type="text/css">

/* Qucik and dirty. I normally use a custom css reset and would not advise using the below. But for the purposes of this tutorial it should be fine. */

* { 
	padding:0;
	margin:0;
}

body {
	font-size:12px;
	font-family:Arial, Helvetica, sans-serif;	
}

fieldset {
	border:none;	
}

form {
	width:930px;
	margin:20% auto;	
	padding:15px;
	border:solid 6px #9FCBFF;
	-moz-border-radius:6px;
	-webkit-border-radius:6px;
	border-radius:6px;
}

input {
	border:none;
	background-color:none;	
}

#signup-email {
	border:1px solid #999999;
	color:#9E9E9E;
	padding:5px;
	margin-left:10px;
	margin-right:4px;
}

#signup-email:focus {
	border-color:#9FCBFF;
	background-color:#DFEEFF;
	background-image:none;
	color:#000;
}

#signup-button {
	background-color:#9FCBFF;
	color:#FFF;
	-moz-border-radius:10px;
	-webkit-border-radius:10px;
	border-radius:10px;
	padding:5px;
	text-shadow: 1px 1px 1px #5FA8FF;	
}

#signup-button:hover {
	cursor:pointer;
	background-color:#7FB9FF;
}

#signup-response {
	display:inline;
	margin-left:4px;
	padding-left:20px;
}

.response-waiting {
	background:url("loading.gif") no-repeat;
}

.response-success {
	background:url("tick.png") no-repeat;
}

.response-error {
	background:url("cross.png") no-repeat;
}

</style>

<!-- We will get our jQuery from google -->
<script src="https://www.google.com/jsapi" type="text/javascript"></script>
<script type="text/javascript">
	google.load('jquery', '1.4.1');
</script>

<script type="text/javascript">
$(document).ready(function(){
	$('#newsletter-signup').submit(function(){
		
		//check the form is not currently submitting
		if($(this).data('formstatus') !== 'submitting'){
		
			//setup variables
			var form = $(this),
				formData = form.serialize(),
				formUrl = form.attr('action'),
				formMethod = form.attr('method'), 
				responseMsg = $('#signup-response');
			
			//add status data to form
			form.data('formstatus','submitting');
			
			//show response message - waiting
			responseMsg.hide()
					   .addClass('response-waiting')
					   .text('Please Wait...')
					   .fadeIn(200);
			
			//send data to server for validation
			$.ajax({
				url: formUrl,
				type: formMethod,
				data: formData,
				success:function(data){
					
					//setup variables
					var responseData = jQuery.parseJSON(data), 
						klass = '';
					
					//response conditional
					switch(responseData.status){
						case 'error':
							klass = 'response-error';
						break;
						case 'success':
							klass = 'response-success';
						break;	
					}
					
					//show reponse message
					responseMsg.fadeOut(200,function(){
						$(this).removeClass('response-waiting')
							   .addClass(klass)
							   .text(responseData.message)
							   .fadeIn(200,function(){
								   //set timeout to hide response message
								   setTimeout(function(){
									   responseMsg.fadeOut(200,function(){
									       $(this).removeClass(klass);
										   form.data('formstatus','idle');
									   });
								   },3000)
								});
					});
				}
			});
		}
		
		//prevent form from submitting
		return false;
	});
});
</script>
</head>

<body>

<form id="newsletter-signup" action="?action=signup" method="post">
    <fieldset>
        <label for="signup-email">Sign up for email offers, news &amp; events:</label>
        <input type="text" name="signup-email" id="signup-email" />
        <input type="submit" id="signup-button" value="Sign Me Up!" />
        <p id="signup-response"></p>
    </fieldset>
</form>

</body>
</html>
