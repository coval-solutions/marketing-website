<?php

$siteOwnersEmail = 'sales@covalsolutions.com';
if ($_POST) {
    $name = trim(stripslashes($_POST['name']));
    $companyName = trim(stripslashes($_POST['company']));
    $email = trim(stripslashes($_POST['email']));
    $phone = trim(stripslashes($_POST['phone']));
    $query = trim(stripslashes($_POST['checkboxs'][0] ?? "Don't Know"));
    $userMessage = trim(stripslashes($_POST['message-textarea']));

    if (strlen($name) < 2) {
        $error['name'] = 'Please enter your name.';
    }

    if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $email)) {
      $error['email'] = 'Please enter a valid email address.';
    }

    if (strlen($userMessage) < 12) {
      $error['message'] = 'Please enter your message. It should have at least 12 characters.';
    }

    $subject = $companyName;
    $message = '<br />';
    $message .= 'Email from: ' . $name . '<br />';
    $message .= 'Email address: ' . $email . '<br />';
    $message .= 'Query: ' . $query . '<br />';
    $message .= 'Message: <br /><br />';
    $message .= $userMessage;
    $message .= '<br />';
    $message .= "<br /> ----- <br /> This email was sent from your site's contact form. <br />";
    
    $from =  $name . " <" . $email . ">";

    $headers = 'From: ' . $from . "\r\n";
	  $headers .= 'Reply-To: ' . $email . "\r\n";
 	  $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

   if (!$error) {
      ini_set("sendmail_from", $siteOwnersEmail);
      $mail = mail($siteOwnersEmail, $subject, $message, $headers);

      if (!$mail) {
        $response = json_encode(['success1' => false]);
        die($response);
      }
	} else {
		$response = (isset($error['name'])) ? $error['name'] . "<br /> \n" : null;
		$response .= (isset($error['email'])) ? $error['email'] . "<br /> \n" : null;
    $response .= (isset($error['message'])) ? $error['message'] . "<br />" : null;
    
    $response = json_encode(['success2' => false]);
    die($response);
  }
  
  $response = json_encode(['success' => true]);
  die($response);
}

?>